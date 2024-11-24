<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'goal',
        'current',
        'gofundme_url',
    ];

    protected $casts = [
        'goal' => 'decimal:2',
        'current' => 'decimal:2',
    ];
}
