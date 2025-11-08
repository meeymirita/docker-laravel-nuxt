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

    protected function configureEmailVerification(): void
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

            // Парсим URL чтобы получить все параметры
            $parsedUrl = parse_url($verifyUrl);
            $path = $parsedUrl['path']; // /api/email/verify/19/908e0e2...
            $query = $parsedUrl['query'] ?? ''; // expires=...&signature=...

            // Извлекаем id и hash из path
            preg_match('/\/api\/email\/verify\/(\d+)\/(.+)/', $path, $matches);
            $id = $matches[1] ?? '';
            $hash = $matches[2] ?? '';

            // Собираем фронтенд URL с ВСЕМИ параметрами в query string
            $frontendUrl = config('app.frontend_url', 'http://localhost:3000');
            $frontendVerifyUrl = $frontendUrl . '/email-verify?' . http_build_query([
                    'id' => $id,
                    'hash' => $hash,
                ]);

            // Добавляем остальные query параметры (expires, signature)
            if ($query) {
                $frontendVerifyUrl .= '&' . $query;
            }

            return (new MailMessage)
                ->subject('Подтверждение email')
                ->line('Здравствуйте! Для завершения регистрации, пожалуйста, подтвердите ваш email.')
                ->action('Подтвердить email', $frontendVerifyUrl)
                ->line('Если вы не создавали аккаунт, просто игнорируйте это письмо.');
        });
    }
}
