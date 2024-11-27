<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationHistory extends Model
{
    protected $fillable = [
        'donation_id',
        'status',
        'payment_provider',
        'payment_details',
        'error_message'
    ];

    protected $casts = [
        'payment_details' => 'array'
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public static function getStatusSummary($timeframe = null)
    {
        $query = self::query();
        
        if ($timeframe) {
            $query->where('created_at', '>=', now()->sub($timeframe));
        }
        
        return $query->selectRaw('status, COUNT(*) as count')
                    ->groupBy('status')
                    ->get();
    }

    public static function getFailureAnalysis($limit = 10)
    {
        return self::where('status', 'failed')
                  ->selectRaw('error_message, COUNT(*) as count')
                  ->groupBy('error_message')
                  ->orderByRaw('COUNT(*) DESC')
                  ->limit($limit)
                  ->get();
    }

    public function getPaymentDetailsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }
}
