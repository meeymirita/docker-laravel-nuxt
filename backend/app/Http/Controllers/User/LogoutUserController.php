<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LogoutUserController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        // удаление всех токенов пользователя
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => 'Вы вышли из аккаунта'
        ]);
    }
}
