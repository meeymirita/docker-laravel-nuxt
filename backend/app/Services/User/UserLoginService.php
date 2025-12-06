<?php

namespace App\Services\User;


use App\Enums\UserCheckLoginField;
use App\Http\Requests\User\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
class UserLoginService
{
    /**
     * @param LoginUserRequest $userData
     * @return array|null
     */
    public function login(LoginUserRequest $userData)
    {

        return $this->auth($this->checkLogin($userData), $userData->login, $userData->password);
    }
    /**
     * @param string $type
     * @param string $login
     * @param string $password
     * @return array|null
     */
    public function auth(string $type, string $login, string $password)
    {

        if (Auth::attempt([$type => $login, 'password' => $password])){
            $user = Auth::user();
            $token = $user->createToken(
                'login_token',
                ['*'],
                now()->addWeek()
            )->plainTextToken;

            return [
                'user' => $user,
                'token' => $token
            ];
        }
        return null;
    }

    /**
     * @param LoginUserRequest $request
     * @return string
     */
    public function checkLogin(LoginUserRequest $request)
    {
        return filter_var($request->get('login'), FILTER_VALIDATE_EMAIL)
            ? UserCheckLoginField::Email->value
            : UserCheckLoginField::Login->value;
    }
}
