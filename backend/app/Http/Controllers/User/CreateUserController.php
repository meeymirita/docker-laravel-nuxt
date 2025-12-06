<?php

namespace App\Http\Controllers\User;

use App\Contracts\UserCreateInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Resources\User\RegisterResponseResource;
use Illuminate\Http\JsonResponse;

class CreateUserController extends Controller
{
    public $userCreate;

    /**
     * @param UserCreateInterface $userCreate
     */
    public function __construct(UserCreateInterface $userCreate)
    {
        $this->userCreate = $userCreate;
    }

    /**
     * @param CreateUserRequest $request
     * @return RegisterResponseResource|JsonResponse
     */
    public function register(CreateUserRequest $request)
    {
        try {
            $data = $this->userCreate->createUser($request->validated());
            return new RegisterResponseResource($data);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Ошибка регистрации', 'error' => $e->getMessage()], 500);
        }
    }
}
