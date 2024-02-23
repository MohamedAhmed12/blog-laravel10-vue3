<?php

namespace App\Modules\User\Routes;

use App\Modules\Auth\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api'])
    ->prefix('api')
    ->post('/login', [AuthController::class, 'login'])->name('login');
