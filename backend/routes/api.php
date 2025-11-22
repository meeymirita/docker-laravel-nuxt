<?php

use App\Http\Controllers\Image\ImageController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\{CreateUserController,
    EmailVerificationController,
    LoginUserController,
    ResetPasswordController};
use App\Http\Resources\User\UserResource;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

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
    // имаге в ресурс для отдачи в другой ресурс
    Route::get('/images/{image}/view', [ImageController::class, 'view'])->name('images.view');
    Route::get('/images/{image}/download', [ImageController::class, 'download'])->name('images.download');
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




Route::get('/test-rabbitmq', function() {
    \App\Jobs\TestRabbitMQJob::dispatch('Hello RabbitMQ!');
    return response()->json(['message' => 'Job dispatched to RabbitMQ']);
});
// Добавь в routes/api.php для тестирования
Route::get('/test-queue', function() {
    $post = \App\Models\Post::first();

    if (!$post) {
        return response()->json(['error' => 'No posts found'], 404);
    }

    \App\Jobs\ProcessPostJob::dispatch(
        action: 'post_created',
        data: $post,
        queue: 'post_created'
    );

    return response()->json([
        'message' => 'Test job dispatched',
        'post_id' => $post->id,
        'queue' => 'post_created'
    ]);
});
Route::get('/check-queue-config', function() {
    return [
        'default_connection' => config('queue.default'),
        'rabbitmq_config' => config('queue.connections.rabbitmq'),
        'env_variables' => [
            'QUEUE_CONNECTION' => env('QUEUE_CONNECTION'),
            'RABBITMQ_QUEUE' => env('RABBITMQ_QUEUE'),
            'RABBITMQ_HOST' => env('RABBITMQ_HOST'),
        ],
        'available_queues' => config('rabbitmq.queues', ['high', 'default', 'low'])
    ];
});
Route::get('/test-queues', function() {
    // Отправляем в разные очереди
    \App\Jobs\TestQueueJob::dispatch('High priority task', 'high');
    \App\Jobs\TestQueueJob::dispatch('Default priority task', 'default');
    \App\Jobs\TestQueueJob::dispatch('Low priority task', 'low');

    return response()->json([
        'message' => 'Test jobs dispatched to different queues',
        'queues' => ['high', 'default', 'low']
    ]);
});
