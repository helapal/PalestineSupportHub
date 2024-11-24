<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::latest()->get();
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
