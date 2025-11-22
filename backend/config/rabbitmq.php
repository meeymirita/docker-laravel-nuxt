<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Конфиг хранит настройки подключения и имена очередей.
    | Приложение берет отсюда параметры для соединения с RabbitMQ.
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Default Queue Connection Name
    |--------------------------------------------------------------------------
    */

    'default' => env('RABBITMQ_QUEUE', 'laravel_queue'),

    /*
    |--------------------------------------------------------------------------
    | RabbitMQ Connections
    |--------------------------------------------------------------------------
    */

    'connections' => [
        'default' => [
            // Домен контейнера
            'host' => env('RABBITMQ_HOST', 'rabbitmq'),
            // Порт RabbitMQ
            'port' => env('RABBITMQ_PORT', 5672),
            // Логин
            'user' => env('RABBITMQ_USER', 'admin'),
            // Пароль
            'password' => env('RABBITMQ_PASSWORD', 'secret'),
            // Виртуальный хост
            'vhost' => env('RABBITMQ_VHOST', '/'),
        ],

    ],
    /*
    |--------------------------------------------------------------------------
    | RabbitMQ queues
    |--------------------------------------------------------------------------
    */
    'queues' => [
        // Основная очередь
        'default' => env('RABBITMQ_QUEUE', 'laravel_queue'),
        // очереди под посты
        'post_created' => 'post_created', // Создание поста
        'post_updated' => 'post_updated', // Обновление поста
        'post_deleted' => 'post_deleted', // Удаление поста

        // Пользователи
        'users_created' => 'users_created', // Создание пользователя
        'users_updated' => 'users_updated', // Обновление пользователя
        'users_deleted' => 'users_deleted', // Удаление пользователя


        'notifications' => 'notifications_queue',
        'emails' => 'emails_queue',
    ],

    /*
    |--------------------------------------------------------------------------
    | RabbitMQ Exchanges
    |--------------------------------------------------------------------------
    */

    'exchanges' => [
        'default' => [
            'name' => 'laravel_exchange',
            'type' => 'direct',
            'passive' => false,
            'durable' => true,
            'auto_delete' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Options
    |--------------------------------------------------------------------------
    */

    'options' => [
        'queue' => [
            'passive' => false,
            'durable' => true,
            'exclusive' => false,
            'auto_delete' => false,
        ],
    ],

];
