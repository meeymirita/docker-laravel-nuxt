<?php

namespace App\Services;


use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UserService
{
    public function createUser(array $userData)
    {
        return DB::transaction(function () use ($userData) {
            $user = User::create([
                'name' => $userData['name'],
                'login' => $userData['login'],
                'email' => $userData['email'],
                'type' => UserType::User->value,
                'status' => UserStatus::Pending->value,
                'password' => Hash::make($userData['password']),
            ]);
            $token = $user->createToken(
                'register_token',
                ['*'],
                now()->addWeek()
            )->plainTextToken;

            event(new Registered($user));

            return [
                'user' => $user,
                'token' => $token,
            ];
        });
    }
}
