<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            \App\Contracts\UserCreateInterface::class,   // "Когда просят этот интерфейс"
            \App\Services\User\UserCreateService::class  // "Дай этот класс"
        );
    }

    public function boot(): void
    {
    }
}
