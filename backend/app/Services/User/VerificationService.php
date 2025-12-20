<?php

namespace App\Services\User;

use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Random\RandomException;

class VerificationService
{
    /**
     * @throws RandomException
     */
    public function sendVerificationCode(User $user): bool
    {
        // генерация кода
        $code = $user->generateVerificationCode();
        try {
            // отправка почты
            Mail::to($user->email)->send(new VerificationCodeMail($user, $code));
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }

    public function resendVerificationCode(User $user): bool
    {
        if (
            $user->verification_code_expires_at &&
            $user->verification_code_expires_at->subMinutes(1) < now()
        ) {
            throw new \Exception('Повторный код можно запросить через 1 минуту');
        }
        return $this->sendVerificationCode($user);
    }


    /**
     * Подтверждение кода
     * @param User $user
     * @param string $code
     * @return bool
     */
    public function verifyCode(User $user, string $code): bool
    {
        if (!$user->verifyCode($code)) {
            return false;
        }

        $user->markEmailAsVerified();
        return true;
    }
}
