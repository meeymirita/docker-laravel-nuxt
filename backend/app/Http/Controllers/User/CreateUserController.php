<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Resources\RegisterResponseResource;
use App\Services\User\UserCreateService;

class CreateUserController extends Controller
{
    public $userCreateService;
    public function __construct(UserCreateService $userCreateService)
    {
        $this->userCreateService = $userCreateService;
    }
    public function register(CreateUserRequest $request)
    {
        try {
            $data = $this->userCreateService->createUser($request->validated());
            return new RegisterResponseResource($data);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Ошибка регистрации', 'error' => $e->getMessage()], 500);
        }
    }
}
