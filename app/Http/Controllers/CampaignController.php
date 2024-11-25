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

        // Progress percentage filtering
        if ($minProgress = $request->input('min_progress')) {
            $query->whereRaw('(current / goal * 100) >= ?', [$minProgress]);
        }

        if ($maxProgress = $request->input('max_progress')) {
            $query->whereRaw('(current / goal * 100) <= ?', [$maxProgress]);
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
            'recurring' => 'required|integer|in:0,7',
            'campaign_ids' => 'required|string'
        ]);

        try {
            // In a real implementation, we would process the payment here
            Log::info("Processing payment of {$validated['amount']} for campaigns: {$validated['campaign_ids']}");
            
            $donation = Donation::create($validated);
            
            // In a real implementation, we would send an email here
            Log::info("Sending confirmation email to {$validated['email']} for donation {$donation->id}");
            
            return redirect()->route('campaigns.index')->with('success', 'Thank you for your donation!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to process donation. Please try again.');
        }
    }
}
