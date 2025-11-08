<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->getVerifyUser();
        if (! $user) return false;
        if (! hash_equals((string) $this->route('id'), (string) $user->getKey())) return false;
        if (! hash_equals((string) $this->route('hash'), sha1($user->getEmailForVerification()))) return false;

        return true;
    }


    public function rules(): array
    {
        return [];
    }

    public function getVerifyUser(): ?User
    {
        return User::find($this->route('id'));
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('Неверная ссылка для подтверждения.');
    }
}
