<?php

namespace App\Modules\Auth\Services;

use App\Modules\User\Models\User;
use App\Modules\Auth\DTOs\LoginDTO;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class AuthService
{
    public function login(LoginDTO $data)
    {
        $user = User::where('username', $data->username)->first();

        if ($user) {
            if (!isset($user->fingerprint)) {
                $this->setUserFingerPrint($user, $data->fingerprint);
            }
            
            if (isset($user->fingerprint) && $user->fingerprint !== $data->fingerprint) {
                return [
                    'message' => 'You cannot login from different device', 'status' => 401
                ];
            }

            if ($user->password === $data->password) {
                Auth::loginUsingId($user->id);

                return [
                    'message' =>
                    [
                        'user' => $user,
                        'token' => $user->createToken('authToken')->plainTextToken
                    ], 'status' => 200
                ];
            }
        }

        return ['message' => 'Unauthorized', 'status' => 401];
    }

    public function logout(User $user): void
    {
        $user->tokens()->delete();
        $user->currentAccessToken()->delete();
    }

    private function setUserFingerPrint(User $user, String $fingerprint): void
    {
        $user->update(['fingerprint' => $fingerprint]);
    }
}
