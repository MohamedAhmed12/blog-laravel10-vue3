<?php

namespace App\Modules\User;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

final class UserServiceProvider extends AuthServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Routes/api.php');
    }
}
