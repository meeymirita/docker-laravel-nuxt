<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Resources\User\LoginResponseResource;
use App\Services\User\UserLoginService;
use Illuminate\Http\JsonResponse;

class LoginUserController extends Controller
{
    public $userLoginService;

    /**
     * @param UserLoginService $userLoginService
     */
    public function __construct(UserLoginService $userLoginService)
    {
        $this->userLoginService = $userLoginService;
    }

    /**
     * @param LoginUserRequest $request
     * @return LoginResponseResource|JsonResponse
     */
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
