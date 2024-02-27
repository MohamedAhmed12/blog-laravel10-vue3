<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Blog\Controllers\BlogController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('api/blogs')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('blogs.list');
        Route::post('/search', [BlogController::class, 'search'])->name('blogs.search');
        Route::post('/', [BlogController::class, 'store'])->name('blogs.create');
        Route::post('/{blog}', [BlogController::class, 'update'])->name('blogs.update');
        Route::delete('/{blog}', [BlogController::class, 'destroy'])->name('blogs.delete');
    });
