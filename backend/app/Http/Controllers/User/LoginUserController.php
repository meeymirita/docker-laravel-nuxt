<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Resources\User\LoginResponseResource;
use App\Services\User\UserLoginService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class LoginUserController extends Controller
{
    public function __construct(
        private readonly UserLoginService $userLoginService
    ) {}

    /**
     * Авторизация пользователя
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $data = $this->userLoginService->login($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Авторизация успешна',
                'data' => new LoginResponseResource($data)
            ], 200);


        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибки валидации',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка сервера',
                'error' => $e->getMessage() ?: null
            ], 500);
        }
    }
}
