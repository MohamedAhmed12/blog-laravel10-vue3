<?php

namespace App\Modules\Auth\Services;

use App\Modules\Auth\DTOs\LoginDTO;
use Illuminate\Support\Facades\Auth;


class AuthService
{
    public function login(LoginDTO $data)
    {
        if (Auth::attempt($data->toArray())) {
            $user = Auth::user();
            return [
                'user' => $user,
                'token' => $user->createToken('authToken')->plainTextToken
            ];
        }
    }
}
