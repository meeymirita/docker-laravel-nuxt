<?php

namespace App\Providers\User;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class UserEmailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->configureEmailVerification();
    }

    protected function configureEmailVerification() : void
    {
        VerifyEmail::toMailUsing(function ($notifiable) {
            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(config('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );

            return (new MailMessage)
                ->subject('Подтверждение email')
                ->line('Здравствуйте! Для завершения регистрации, пожалуйста, подтвердите ваш email.')
                ->action('Подтвердить email', $verifyUrl)
                ->line('Если вы не создавали аккаунт, просто игнорируйте это письмо.');
        });
    }
}
