<?php

namespace App\Modules\Auth\Services;

use App\Modules\User\Models\User;
use App\Modules\Auth\DTOs\LoginDTO;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(LoginDTO $data)
    {
        $user = User::where('username', $data->username)->first();
        if ($user && $user->password === $data->password) {
            Auth::loginUsingId($user->id);

            return [
                'user' => $user,
                'token' => $user->createToken('authToken')->plainTextToken
            ];
        }
    }

    public function logout(User $user): void
    {
        $user->tokens()->delete();
        $user->currentAccessToken()->delete();
    }
}
