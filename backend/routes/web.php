<?php

use Illuminate\Support\Facades\Route;
use App\Jobs\TestRabbitJob;

Route::get('/test-rabbit', function () {
    TestRabbitJob::dispatch('Hello from RabbitMQ!');
    return 'Job dispatched to RabbitMQ!';
});
Route::get('/', function () {
    return view('welcome');
});
// RabbitMQ branch
