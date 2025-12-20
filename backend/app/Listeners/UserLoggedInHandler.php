<?php

namespace App\Listeners;

use App\Events\UserLoggedInEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class UserLoggedInHandler implements ShouldQueue
{
    public $queue = 'laravel_queue'; // Явно указываем очередь rabbitmq
    public $connection = 'rabbitmq'; // Явно указываем соединение

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLoggedInEvent $event): void
    {
        try {
            // Вариант 1: С меткой
            Log::info('🎯 UserLoggedInEvent handled successfully', [
                'name' => $event->myArray['name'] ?? 'unknown',
                'skill' => $event->myArray['skill'] ?? 'unknown',
                'timestamp' => now()->toDateTimeString(),
                'queue' => $this->queue
            ]);

            // Вариант 2: Просто строка
            Log::info('Event data: ' . json_encode($event->myArray));

            // Вариант 3: В отдельный файл для уверенности
            file_put_contents(
                storage_path('logs/rabbitmq_success.log'),
                date('Y-m-d H:i:s') . ' - SUCCESS: ' . json_encode($event->myArray) . PHP_EOL,
                FILE_APPEND
            );

        } catch (\Throwable $e) {
            Log::error('❌ UserLoggedInHandler failed: ' . $e->getMessage(), [
                'event_data' => $event->myArray ?? [],
                'error' => $e->getTraceAsString()
            ]);

            // Перебрасываем исключение, чтобы job отметился как failed
            throw $e;
        }
    }
}
