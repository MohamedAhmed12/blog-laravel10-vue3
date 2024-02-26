<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Blog\Controllers\BlogController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('api/blogs')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('blogs.list');
       });
