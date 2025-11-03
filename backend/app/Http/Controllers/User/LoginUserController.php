<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Resources\LoginResponseResource;
use App\Http\Resources\UserResource;
use App\Services\User\UserLoginService;

class LoginUserController extends Controller
{
    public $userLoginService;

    public function __construct(UserLoginService $userLoginService)
    {
        $this->userLoginService = $userLoginService;
    }

    public function login(LoginUserRequest $request)
    {
        try {
            $data = $this->userLoginService->login($request);
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Пароль или логин не верный'
                ], 401);
            }
            return new LoginResponseResource($data);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
