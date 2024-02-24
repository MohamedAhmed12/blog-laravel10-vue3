<?php

namespace App\Modules\User\factories;

use App\Modules\User\Constants\UserRoles;
use App\Modules\User\Constants\UserStatuses;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

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
            'password' => static::$password ??= Hash::make('password'),
            'username' => fake()->name(),
            'remember_token' => Str::random(10),
        ];
    }
}
