<?php

namespace App\Providers;

use App\Events\UserLoggedInEvent;
use App\Listeners\UserLoggedInHandler;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected $listen = [
        UserLoggedInEvent::class => [
            UserLoggedInHandler::class,
//            SendWelcomeEmailListener::class,
//            UpdateLastLoginListener::class,
//            LogLoginActivityListener::class,
        ],
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }

    // Отключение автообнаружевания
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
