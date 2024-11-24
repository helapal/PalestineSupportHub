<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;
    
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
