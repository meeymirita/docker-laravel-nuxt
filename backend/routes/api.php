<?php
use App\Http\Controllers\User\EmailVerificationController;
use App\Http\Controllers\User\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;

//  без защиты
Route::prefix('user')->name('user.')->group(function () {
    Route::post('/register', [UserController::class, 'register'])->name('register');
});

// подтверждение емаил
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware('signed')
    ->name('verification.verify');

// защита санктумом и verified который проверяет подтверждена ли ебаная почта
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/profile', function () {
        // resolve удаляет data {}
        return (new UserResource(auth()->user()))->resolve();
    });

    Route::get('/dashboard', function () {
        return response()->json(['message' => 'Dashboard data']);
    });
});
