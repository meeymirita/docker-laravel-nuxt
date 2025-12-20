<?php

use App\Events\UserLoggedInEvent;
use App\Http\Controllers\Image\ImageController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\SendVerificationCodeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\VerifyEmailController;
use App\Http\Resources\User\UserResource;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\Route;
//  без защиты events
Route::prefix('user')->name('user.')->group(callback: function () {
    //ругистрация с отправкой письма на почту для подтверждения её
    Route::post( '/register', action: [UserController::class, 'register'])->name('register');
    // Подтверждение email
    Route::post('/verify-email', [VerifyEmailController::class, 'verify']);
    Route::post('/send-verification-code', [SendVerificationCodeController::class, 'sendCode']);
    Route::post('/resend-verification-code', [SendVerificationCodeController::class, 'resendCode']);
    // вход в аккаунт
    Route::post('/login', action: [UserController::class, 'login'])->name('login');

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
// 123
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
Route::get('/check-image-path', function () {
    $paths = [
        'storage_path' => storage_path('app/public/imagesToEmails/registerImage/himary.jpg'),
        'public_storage' => public_path('storage/imagesToEmails/registerImage/himary.jpg'),
        'exists_storage' => file_exists(storage_path('app/public/imagesToEmails/registerImage/himary.jpg')),
        'exists_public' => file_exists(public_path('storage/imagesToEmails/registerImage/himary.jpg')),
    ];

    return response()->json($paths);
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
Route::get('/test-rabbitmq-connection', function () {
    try {
        // Проверка соединения с RabbitMQ
        $connection = app('queue')->connection('rabbitmq');
        $queue = $connection->getQueue();

        return response()->json([
            'status' => 'success',
            'queue_connection' => 'rabbitmq',
            'queue_name' => $queue,
            'config' => [
                'host' => env('RABBITMQ_HOST'),
                'port' => env('RABBITMQ_PORT'),
                'user' => env('RABBITMQ_USER'),
                'queue' => env('RABBITMQ_QUEUE')
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'suggestion' => 'Check if RabbitMQ container is running: docker ps | grep rabbitmq'
        ], 500);
    }
});

// Добавьте в routes/api.php
Route::get('/test-simple-event', function () {
    // 1. Очищаем все предыдущие регистрации
    \Illuminate\Support\Facades\Event::forget(\App\Events\UserLoggedInEvent::class);

    // 2. Вручную регистрируем ТОЛЬКО ОДИН listener
    \Illuminate\Support\Facades\Event::listen(
        \App\Events\UserLoggedInEvent::class,
        [\App\Listeners\UserLoggedInHandler::class, 'handle']
    );

    // 3. Проверяем количество
    $listeners = \Illuminate\Support\Facades\Event::getListeners(
        \App\Events\UserLoggedInEvent::class
    );

    // 4. Логируем начало теста
    \Log::info('===== SIMPLE TEST START =====');

    // 5. Создаем уникальные данные для отслеживания
    $data = [
        'name' => 'mirita',
        'skill' => 'php',
        'unique_id' => uniqid(),
        'timestamp' => microtime(true)
    ];

    // 6. Диспатчим событие
    \App\Events\UserLoggedInEvent::dispatch($data);

    // 7. Логируем конец теста
    \Log::info('===== SIMPLE TEST END ===== ', $data);

    return response()->json([
        'test_type' => 'simple_event_test',
        'listeners_count' => count($listeners),
        'expected' => 1,
        'data' => $data,
        'instructions' => 'Check storage/logs/laravel.log for listener output'
    ]);
});

Route::get('/test', function () {
    $data = [
        'name' => 'mirita',
        'skill' => 'php'
    ];
    \App\Events\UserLoggedInEvent::dispatch($data);
    return response()->json([
        'data' => $data,
    ]);
});
Route::get('/test-mail', function () {
    try {
        \Mail::raw('Тестовое письмо из Laravel', function ($message) {
            $email = 'nik.lyamkin@yandex.ru';
            //роверил в сообщения так ставить storage_path('app/public/me.jpg')
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


//mysql
//  docker-compose -f docker-compose.prod.yml exec mysql bash
// mysql -u root -p / password
// mysql> use laravel
// mysql> DELETE FROM users WHERE email = 'nik.lyamkin@yandex.ru';
