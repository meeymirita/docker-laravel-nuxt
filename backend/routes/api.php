<?php

use App\Http\Controllers\PostController;
use App\Http\Resources\UserResource;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\{CreateUserController,
    LoginUserController,
    EmailVerificationController,
    ResetPasswordController
};
//  без защиты
Route::prefix('user')->name('user.')->group(function () {
    Route::post('/register', [CreateUserController::class, 'register'])->name('register');
    Route::post('/login', [LoginUserController::class, 'login'])->name('login');

});
/*
 *   подтверждение емаил и сбросами парооля тоже относится к роутам
 *      verification.verify . sendResetLink . password.reset
 *      если положить внутрь группы юзер то роут нейм будет user.verification.verify и если в AppServiceProvider.php поменять роут тоже
 *      не будет работать видит по дефолту только verification.verify
 *
 *      такая ошибка
 *          [2025-11-03 10:36:00] local.ERROR:
 *          Error firing Registered event
 *          {"error":"Route [verification.verify] not defined.","user_id":6}
*/
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware('signed')
    ->name('verification.verify');
Route::post('/send-reset-link', [ResetPasswordController::class, 'sendResetLink'])
    ->name('sendResetLink');
Route::post('/reset-password/{token}', [ResetPasswordController::class, 'passwordReset'])
    ->name('password.reset');

Route::prefix('posts')->name('posts.')->group(function () {
    // все посты на главную
    Route::get('/', [PostController::class, 'index'])->name('index');

    Route::middleware('auth:sanctum')->group(function () {
        // посты авторизованного пользователя в профиле
        Route::get('/my-posts', [PostController::class, 'userPosts'])->name('userPosts');
    });
    // посмотреть пост
    Route::get('/{post}', [PostController::class, 'show'])->name('show');

    // действия с постами авторизованного пользователя
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::put('/{post}', [PostController::class, 'update'])->name('update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
    });
});


Route::get('/check', function() {
    return response()->json([
        'authenticated' => Auth::check(),
        'user' => Auth::user()
    ]);
})->middleware('auth:sanctum');
//  auth:sanctum и verified -> и если толька почта подтверждена
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/profile', function () {
        // resolve удаляет data {}
        return (new UserResource(auth()->user()))->resolve();
    });

    Route::get('/dashboard', function () {
        return response()->json(['message' => 'Dashboard data']);
    });
});



Route::get('/test', function() {
    $data = Post::with('user:id,name,login', 'tags:id,name,color', 'comments.user:id,name')
        ->find(1);
    return $data;
});
