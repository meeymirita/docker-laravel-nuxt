<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index']);
// Redis
//Route::get('/posts', [PostController::class, 'index']);
//Route::get('/posts/{id}', [PostController::class, 'show']);
// RabbitMQ branch
// routes/web.php
//Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{id}', [PostController::class, 'show']);
