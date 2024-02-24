<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\User\Models\User;
use App\Modules\User\Constants\UserRoles;
use Illuminate\Support\Facades\Crypt;

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
            'username' => 'admin',
            'password' =>  Crypt::encryptString('password'),
            'role' => UserRoles::ADMIN,
        ]);

        // Create 10 subscriber users
        User::factory()->count(10)->create();
    }
}
