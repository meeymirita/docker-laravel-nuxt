<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fuck', [\App\Http\Controllers\FuckController::class, 'index']);
