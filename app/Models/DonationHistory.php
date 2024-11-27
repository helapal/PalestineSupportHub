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

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
