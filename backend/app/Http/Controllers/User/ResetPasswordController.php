<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::ResetLinkSent
            ? response()->json(['status' => __($status)], 200)
            : response()->json(['email' => __($status)], 422);
    }

    /**
     * @param Request $request
     * @param $token
     * @return JsonResponse
     */
    public function passwordReset(Request $request, $token)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            array_merge($request->only('email', 'password', 'password_confirmation'), ['token' => $token]),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();
                $user->tokens()->delete();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PasswordReset
            ? response()->json(['status' => __($status)], 200)
            : response()->json(['status' => __($status)], 422);
    }
}
