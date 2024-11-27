<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        // Get campaigns needing support (lowest progress ratio)
        $needingSupportCampaigns = Campaign::needingSupport()
            ->take(3)
            ->get();

        $query = Campaign::query();
        
        // Apply sorting
        $sortField = $request->input('sort', 'created_at');
        $sortOrder = $request->input('order', 'desc');
        
        if (in_array($sortField, ['current', 'goal', 'created_at'])) {
            $query->orderBy($sortField, $sortOrder === 'asc' ? 'asc' : 'desc');
        }

        // Exclude campaigns that are already in the needing support section
        $query->whereNotIn('id', $needingSupportCampaigns->pluck('id'));

        // Apply filtering
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Date range filtering
        if ($startDate = $request->input('start_date')) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate = $request->input('end_date')) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Goal amount range filtering
        if ($minGoal = $request->input('min_goal')) {
            $query->where('goal', '>=', $minGoal);
        }

        if ($maxGoal = $request->input('max_goal')) {
            $query->where('goal', '<=', $maxGoal);
        }

        // Current amount range filtering
        if ($minAmount = $request->input('min_amount')) {
            $query->where('current', '>=', $minAmount);
        }

        if ($maxAmount = $request->input('max_amount')) {
            $query->where('current', '<=', $maxAmount);
        }

        // Progress percentage filtering - PostgreSQL specific
        if ($minProgress = $request->input('min_progress')) {
            $query->whereRaw('(CAST(current AS DECIMAL) / CAST(goal AS DECIMAL) * 100) >= ?', [$minProgress]);
        }

        if ($maxProgress = $request->input('max_progress')) {
            $query->whereRaw('(CAST(current AS DECIMAL) / CAST(goal AS DECIMAL) * 100) <= ?', [$maxProgress]);
        }

        // Additional filters for campaign status
        if ($request->filled('status')) {
            $status = $request->input('status');
            switch ($status) {
                case 'urgent':
                    $query->whereRaw('(CAST(current AS DECIMAL) / CAST(goal AS DECIMAL)) < 0.25');
                    break;
                case 'almost_funded':
                    $query->whereRaw('(CAST(current AS DECIMAL) / CAST(goal AS DECIMAL)) >= 0.75');
                    break;
                case 'newly_added':
                    $query->where('created_at', '>=', now()->subDays(7));
                    break;
            }
        }

        // Sort by progress
        if ($sortField === 'progress') {
            $query->orderByRaw(
                '(CAST(current AS DECIMAL) / CAST(goal AS DECIMAL)) ' . 
                ($sortOrder === 'asc' ? 'ASC' : 'DESC')
            );
        }

        // Apply pagination
        $campaigns = $query->paginate(6)->withQueryString();
        
        return view('campaigns.index', compact('campaigns', 'needingSupportCampaigns'));
    }

    public function donate(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'amount' => 'required|numeric|min:1',
            'recurring_frequency' => 'required|string|in:none,weekly',
            'campaign_ids' => 'required|string'
        ]);

        try {
            $donation = new Donation($validated);
            $donation->save();
            
            // Log initial donation status
            $donation->logHistory('pending', null, 'Processing initial donation');

            try {
                // In a real implementation, we would process the payment here
                Log::info("Processing payment of {$validated['amount']} for campaigns: {$validated['campaign_ids']}");
                
                // Set up recurring payment schedule if weekly is selected
                if ($validated['recurring_frequency'] === 'weekly') {
                    $donation->scheduleNextPayment();
                }
                
                // Log successful payment
                $donation->logHistory(
                    'completed',
                    'mock_payment_provider', // Replace with actual payment provider in production
                    json_encode([
                        'amount' => $validated['amount'],
                        'campaign_ids' => $validated['campaign_ids'],
                        'timestamp' => now()
                    ])
                );
                
                // In a real implementation, we would send an email here
                Log::info("Sending confirmation email to {$validated['email']} for donation {$donation->id}");
                
                $message = $donation->isRecurring()
                    ? 'Thank you for your recurring donation! Your first payment has been processed.'
                    : 'Thank you for your donation!';
                
                return redirect()->route('campaigns.index')->with('success', $message);
            } catch (\Exception $e) {
                // Log payment failure
                $donation->logHistory('failed', null, null, $e->getMessage());
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Donation processing failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to process donation. Please try again.');
        }
    }
}
