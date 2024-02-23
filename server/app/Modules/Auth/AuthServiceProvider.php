<?php

namespace App\Modules\Auth;

// use Illuminate\Support\Facades\Gate;

use App\Modules\Auth\Models\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/Routes/api.php');
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
