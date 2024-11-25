<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Donation extends Model
{
    protected $fillable = [
        'email',
        'amount',
        'recurring_frequency',
        'campaign_ids',
        'next_payment_date',
        'last_payment_date',
        'is_active'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_active' => 'boolean',
        'next_payment_date' => 'datetime',
        'last_payment_date' => 'datetime',
    ];

    public function scheduleNextPayment()
    {
        if ($this->recurring_frequency === 'weekly' && $this->is_active) {
            $this->next_payment_date = Carbon::now()->addWeek();
            $this->save();
        }
    }

    public function cancelRecurring()
    {
        $this->is_active = false;
        $this->next_payment_date = null;
        $this->save();
    }

    public function isRecurring()
    {
        return $this->recurring_frequency !== 'none' && $this->is_active;
    }

    public function scopeActiveRecurring($query)
    {
        return $query->where('is_active', true)
                    ->where('recurring_frequency', '!=', 'none')
                    ->whereNotNull('next_payment_date');
    }

    public function scopeDueForProcessing($query)
    {
        return $query->activeRecurring()
                    ->where('next_payment_date', '<=', Carbon::now());
    }
}
