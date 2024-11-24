<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;

Route::get('/', [CampaignController::class, 'index'])->name('campaigns.index');
Route::post('/donate', [CampaignController::class, 'donate'])->name('campaigns.donate');
