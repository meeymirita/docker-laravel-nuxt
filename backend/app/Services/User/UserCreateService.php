<?php

namespace App\Services\User;


use App\Contracts\UserCreateInterface;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserCreateService implements UserCreateInterface
{
    /**
     * @param array $userData
     * @return array|mixed
     * @throws \Throwable
     */
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
//            $token = $user->createToken(
//                'register_token',
//                ['*'],
//                now()->addWeek()
//            )->plainTextToken;

            try {
                event(new Registered($user));
            } catch (\Exception $e) {
                \Log::error('e', [
                    'error' => $e->getMessage(),
                    'user_id' => $user->id
                ]);
            }

            return [
                'user' => $user,
//                'token' => $token,
            ];
        });
    }
}
