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
        $query = Campaign::query();

        // Apply sorting
        $sortField = $request->input('sort', 'created_at');
        $sortOrder = $request->input('order', 'desc');
        
        if (in_array($sortField, ['current', 'goal', 'created_at'])) {
            $query->orderBy($sortField, $sortOrder === 'asc' ? 'asc' : 'desc');
        }

        // Apply filtering
        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        if ($minAmount = $request->input('min_amount')) {
            $query->where('current', '>=', $minAmount);
        }

        if ($maxAmount = $request->input('max_amount')) {
            $query->where('current', '<=', $maxAmount);
        }

        // Apply pagination
        $campaigns = $query->paginate(6)->withQueryString();
        
        return view('campaigns.index', compact('campaigns'));
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
