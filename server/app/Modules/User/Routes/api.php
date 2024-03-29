<?php

use Illuminate\Support\Facades\Route;
use App\Modules\User\Controllers\SubscriberController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('api/subscribers')->group(function () {
        Route::get('/', [SubscriberController::class, 'index'])->name('subscribers.list');
        Route::post('/search', [SubscriberController::class, 'search'])->name('subscribers.search');
        Route::post('/', [SubscriberController::class, 'store'])->name('subscribers.create');
        Route::post('/{subscriber}', [SubscriberController::class, 'update'])->name('subscribers.update');
        Route::delete('/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.delete');
    });
