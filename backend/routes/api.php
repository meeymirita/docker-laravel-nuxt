<?php

use App\Http\Controllers\Image\ImageController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\{AccountUserController,
    CreateUserController,
    EmailVerificationController,
    LoginUserController,
    LogoutUserController,
    ResetPasswordController,
    UpdateUserController};
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Route;

//premain
//  без защиты
Route::prefix('user')->name('user.')->group(callback: function () {
    //ругистрация с отправкой письма на почту для подтверждения её
    Route::post( '/register', action: [CreateUserController::class, 'register'])->name('register');
    // вход в аккаунт
    Route::post('/login', action: [LoginUserController::class, 'login'])->name('login');
    /*
     * Отдаёт текущего пользователя с его постами пагинация на 10 постов
     */
    Route::get('/profile', action: [AccountUserController::class, 'profile'])
        ->middleware(['auth:sanctum'])
        ->name('profile');
    // обновление данных пользователя ТОЛЬКО ИНФОРМАЦИЯ О НЁМ СДЕЛАТЬ ТУТ
    Route::post('/update', action: [UpdateUserController::class, 'update'])
        ->middleware(['auth:sanctum'])
        ->name('update');
    // выход из аккаунта
    Route::post('/logout', action: [LogoutUserController::class, 'logout'])
        ->middleware(['auth:sanctum'])
        ->name('logout');

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


Route::get('/check', function () {
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


Route::get('/test-rabbitmq', function () {
    \App\Jobs\TestRabbitMQJob::dispatch('Hello RabbitMQ!');
    return response()->json(['message' => 'Job dispatched to RabbitMQ']);
});
// тест
Route::get('/test-queue', function () {
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
Route::get('/check-queue-config', function () {
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
Route::get('/test-queues', function () {
    // разные очереди
    \App\Jobs\TestQueueJob::dispatch('High priority task', 'high');
    \App\Jobs\TestQueueJob::dispatch('Default priority task', 'default');
    \App\Jobs\TestQueueJob::dispatch('Low priority task', 'low');

    return response()->json([
        'message' => 'Test jobs dispatched to different queues',
        'queues' => ['high', 'default', 'low']
    ]);
});
Route::get('/test', function () {
    return 'api test';
});
Route::get('/test-mail', function () {
    try {
        \Mail::raw('Тестовое письмо из Laravel', function ($message) {
            $email = 'nik.lyamkin@yandex.ru';
            $message->to($email)
                ->subject('Тест отправки почты');
        });

        return 'Письмо отправлено!';
    } catch (\Exception $e) {
        return 'Ошибка: ' . $e->getMessage();
    }
});
// docker-compose -f docker-compose.prod.yml exec laravel bash лара
// docker-compose -f docker-compose.prod.yml up -d поднять
