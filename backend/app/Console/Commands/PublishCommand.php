<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish message to RabbitMQ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password')
        );
        $channel = $connection->channel();

        // Объявляем exchange
        $channel->exchange_declare(
            'laravel_exchange', // имя exchange
            'fanout',
            false,
            false,
            false
        );

        // ОШИБКА: здесь должно быть 'laravel', а не 'laravel_exchange'
        $channel->queue_declare(
            'laravel',
            false,
            false,
            false,
            false
        );

        // Биндим очередь к exchange
        $channel->queue_bind('laravel', 'laravel_exchange');

        // Отправляем сообщение в exchange
        $data = [
            'title' => 'Title',
            'content' => 'Content',
            'some_content' => 'Some content',
            'timestamp' => now()->toDateTimeString()
        ];
        $msg = new AMQPMessage(
            json_encode($data),
            ['content_type' => 'application/json']
        );
        $channel->basic_publish($msg, 'laravel_exchange');

        $this->info(" [x] Sent: " . json_encode($data, JSON_UNESCAPED_UNICODE));

        $channel->close();
        $connection->close();
    }
}
