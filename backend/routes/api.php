<?php

use App\Http\Controllers\Image\ImageController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\SendVerificationCodeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\VerifyEmailController;
use App\Http\Resources\User\UserResource;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\Route;
//  без защиты
Route::prefix('user')->name('user.')->group(callback: function () {
    //ругистрация с отправкой письма на почту для подтверждения её
    Route::post( '/register', action: [UserController::class, 'register'])->name('register');
    // Подтверждение email
    Route::post('/verify-email', [VerifyEmailController::class, 'verify']);
    Route::post('/send-verification-code', [SendVerificationCodeController::class, 'sendCode']);
    Route::post('/resend-verification-code', [SendVerificationCodeController::class, 'resendCode']);
    // вход в аккаунт
//    Route::post('/login', action: [UserController::class, 'login'])->name('login');

//    /*
//     * Отдаёт текущего пользователя с его постами пагинация на 10 постов
//     */
//    Route::get('/profile', action: [AccountUserController::class, 'profile'])
//        ->middleware(['auth:sanctum'])
//        ->name('profile');
//    // роут на страницу пользователя по нику +-
////    Route::get('/{login}', action: [AccountUserController::class, 'profile'])
////        ->name('user-account');
//    // обновление данных пользователя
//    Route::post('/update', action: [UpdateUserController::class, 'update'])
//        ->middleware(['auth:sanctum', 'can:update,user']) // 'user' === auth()->user()
//        ->name('update');
//    // выход из аккаунта
//    Route::post('/logout', action: [LogoutUserController::class, 'logout'])
//        ->middleware(['auth:sanctum'])
//        ->name('logout');
//
//    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
//        ->middleware('signed')
//        ->name('verification.verify');
//    Route::post('/send-reset-link', [ResetPasswordController::class, 'sendResetLink'])
//        ->name('sendResetLink');
//    Route::post('/reset-password/{token}', [ResetPasswordController::class, 'passwordReset'])
//        ->name('password.reset');
});

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


// тест
Route::get('/test-image',function (){
    return response()->json([
        'success' => storage_path('himary.jpg'),
    ]);
});
Route::get('/test-rabbitmq', function () {
    \App\Jobs\TestRabbitMQJob::dispatch('Hello RabbitMQ!');
    return response()->json(['message' => 'Job dispatched to RabbitMQ']);
});
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
            // Attachment::fromPath из доки https://laravel.com/docs/12.x/mail
            $attachment = Attachment::fromPath(storage_path('app/public/me.jpg'));
            // к меседжу
            $message->attach($attachment);

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
Route::get('/test-limit', [TestController::class, 'testLimit']);
