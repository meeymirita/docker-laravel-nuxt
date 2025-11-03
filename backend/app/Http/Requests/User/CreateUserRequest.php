<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255|min:3|regex:/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u',
            'login' => 'required|string|max:255|min:3|unique:users,login|alpha_dash',
            'email' => 'required|email:rfc,dns|unique:users,email|max:255',
            'password' => 'required|min:3|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Поле имени обязательно для заполнения',
            'name.string' => 'Имя должно быть строкой',
            'name.max' => 'Имя не должно превышать 255 символов',
            'name.min' => 'Имя должно содержать минимум 3 символа',
            'name.regex' => 'Имя может содержать только буквы, пробелы и дефисы',

            'login.required' => 'Поле логина обязательно для заполнения',
            'login.string' => 'Логин должен быть строкой',
            'login.max' => 'Логин не должен превышать 255 символов',
            'login.min' => 'Логин должен содержать минимум 3 символа',
            'login.unique' => 'Этот логин уже занят',
            'login.alpha_dash' => 'Логин может содержать только буквы, цифры, дефисы и подчеркивания',

            'email.required' => 'Поле email обязательно для заполнения',
            'email.email' => 'Введите корректный email адрес',
            'email.unique' => 'Этот email уже зарегистрирован',
            'email.max' => 'Email не должен превышать 255 символов',

            'password.required' => 'Поле пароля обязательно для заполнения',
            'password.min' => 'Пароль должен содержать минимум 3 символа',
            'password.confirmed' => 'Пароли не совпадают',
            'password.regex' => 'Пароль должен содержать хотя бы одну заглавную букву, одну строчную букву и одну цифру',
        ];
    }
}
