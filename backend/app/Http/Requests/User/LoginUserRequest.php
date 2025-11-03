<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => [
                'required',
                'string',
                'min:3',
                function ($attribute, $value, $fail) {
                    $exists = User::where('login', $value)
                        ->orWhere('email', $value)
                        ->exists();

                    if (!$exists) {
                        $fail('Пользователь с таким логином или email не найден.');
                    }
                },
            ],
            'password' => 'required|min:3',
        ];
    }
    public function messages(): array
    {
        return [
            'login.required' => 'Поле логина обязательно для заполнения',
            'login.string' => 'Логин должен быть строкой',
            'login.min' => 'Логин должен содержать минимум 3 символа',

            'password.required' => 'Поле пароля обязательно для заполнения',
            'password.min' => 'Пароль должен содержать минимум 3 символа',
            'password.regex' => 'Пароль должен содержать хотя бы одну заглавную букву, одну строчную букву и одну цифру',
        ];
    }
}
