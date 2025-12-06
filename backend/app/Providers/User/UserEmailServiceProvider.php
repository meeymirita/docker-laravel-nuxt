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
            $backendUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(config('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );
            $typeAppEnv = config('app.env');

            if ($typeAppEnv === 'local') {
                $frontendUrl = config('app.frontend_url_local', 'http://localhost:8080');
            } else {
                $frontendUrl = config('app.frontend_url_production', 'https://meeymirita.ru');
            }

            $parsedUrl = parse_url($backendUrl);
            $path = $parsedUrl['path'];

            preg_match('/\/api\/email\/verify\/(\d+)\/([^?]+)/', $path, $matches);

            if (!isset($matches[1]) || !isset($matches[2])) {
                throw new \Exception('Failed to parse verification URL');
            }

            $id = $matches[1];
            $hash = $matches[2];
            $query = $parsedUrl['query'] ?? ''; // expires=...&signature=...

            $frontendVerifyUrl = $frontendUrl . '/email/verify?' . http_build_query([
                    'id' => $id,
                    'hash' => $hash,
                ]);

            if ($query) {
                parse_str($query, $queryParams);
                $frontendVerifyUrl .= '&' . http_build_query([
                        'expires' => $queryParams['expires'] ?? '',
                        'signature' => $queryParams['signature'] ?? ''
                    ]);
            }

            \Log::info('Generated frontend URL:', ['url' => $frontendVerifyUrl]);

            return (new MailMessage)
                ->subject('Подтверждение email')
                ->line('Здравствуйте! Для завершения регистрации, пожалуйста, подтвердите ваш email.')
                ->action('Подтвердить email', $frontendVerifyUrl)
                ->line('Если вы не создавали аккаунт, просто игнорируйте это письмо.');
        });
    }
}
