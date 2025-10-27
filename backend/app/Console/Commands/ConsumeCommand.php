<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ConsumeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume messages from RabbitMQ';

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

        // Объявляем exchange (должен совпадать с публикацией)
        $channel->exchange_declare(
            'laravel_exchange',
            'fanout',
            false,
            false,
            false
        );

        // Объявляем очередь (ОБЯЗАТЕЛЬНО должно быть!)
        $channel->queue_declare('laravel', false, false, false, false);

        // Биндим очередь к exchange
        $channel->queue_bind('laravel', 'laravel_exchange');

        $this->info(" [*] Waiting for messages. To exit press CTRL+C\n");

        $callback = function (AMQPMessage $msg) {
            $data = json_decode($msg->getBody(), true);

            $this->info(" [x] Received message:");
            $this->info(json_encode($data, JSON_UNESCAPED_UNICODE));
        };

        $channel->basic_consume(
            'laravel', // queue
            '',        // consumer tag
            false,     // no_local
            true,      // no_ack
            false,     // exclusive
            false,     // no_wait
            $callback  // callback
        );

        try {
            while ($channel->is_consuming()) {
                $channel->wait();
            }
        } catch (\Throwable $exception) {
            $this->error('Error: ' . $exception->getMessage());
        }

        $channel->close();
        $connection->close();
    }
}
