<?php

use Illuminate\Support\Facades\Route;
use App\Modules\User\Controllers\SubscriberController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('api/subscribers')->group(function () {
        Route::post('/', [SubscriberController::class, 'store'])->name('subscribers.create');
    });
