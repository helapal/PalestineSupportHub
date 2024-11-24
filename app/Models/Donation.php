<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'email',
        'amount',
        'recurring',
        'campaign_ids',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'recurring' => 'integer',
    ];
}
