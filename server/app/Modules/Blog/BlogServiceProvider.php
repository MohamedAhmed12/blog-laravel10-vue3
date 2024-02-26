<?php

namespace App\Modules\Blog;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

final class BlogServiceProvider extends AuthServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Routes/api.php');
    }
}
