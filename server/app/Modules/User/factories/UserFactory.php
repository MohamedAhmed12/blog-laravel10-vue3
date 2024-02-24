<?php

namespace App\Modules\User\factories;

use App\Modules\User\Constants\UserRoles;
use App\Modules\User\Constants\UserStatuses;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->name(),
            'password' => 'password',
            'remember_token' => Str::random(10),
        ];
    }
}
