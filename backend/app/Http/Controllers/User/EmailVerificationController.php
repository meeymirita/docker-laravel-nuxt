<?php

namespace App\Http\Controllers\User;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyEmailRequest;
use App\Services\UserService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\DB;

class EmailVerificationController extends Controller
{
    public function verify(VerifyEmailRequest $request)
    {
        $user = $request->getVerifyUser();

        if (!$user) {
            return response()->json(['message' => 'Пользователь не найден.'], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email уже подтверждён.'], 422);
        }

        try {
            DB::transaction(function () use ($user) {
                $user->update([
                    'email_verified_at' => now(),
                    'status' => UserStatus::Active,
                ]);

                event(new Verified($user));
            });

            return response()->json(['message' => 'Ваш email успешно подтверждён!']);
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => 'Ошибка подтверждения email.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
