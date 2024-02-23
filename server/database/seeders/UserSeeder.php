<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Modules\User\Constants\UserRoles;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@blog.com',
            'password' => Hash::make('password'),
            'role' => UserRoles::ADMIN,
        ]);

        // Create 10 subscriber users
        User::factory()->count(10)->create();
    }
}
