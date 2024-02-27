<?php

namespace App\Modules\Auth\Controllers;


use Illuminate\Http\Request;
use App\Modules\Auth\DTOs\LoginDTO;
use Illuminate\Support\Facades\Log;
use App\Modules\Auth\Services\AuthService;
use App\Modules\Auth\FormRequests\LoginFormRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AuthController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login user.
     */

    public function login(LoginFormRequest $request)
    {
        $validatedData = $request->validated();

        $loginDTO = new LoginDTO(...$validatedData);

        $res = $this->authService->login($loginDTO);

        if ($res) {
            Log::info($res);
            return response()->json($res['message'], $res['status']);
        }
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());
        return response()->json(['message' => 'Logged out successfully']);
    }
}
