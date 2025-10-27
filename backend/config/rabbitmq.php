<?php
return [
    'host' => env('RABBITMQ_HOST', 'rabbitmq'),
    'port' => env('RABBITMQ_PORT', 5672),
    'user' => env('RABBITMQ_USER', 'rabbitmq'),
    'password' => env('RABBITMQ_PASSWORD', 'secret'),
    'vhost' => env('RABBITMQ_VHOST', '/'),
];
