<?php

namespace App\Http\Controllers\User;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\JsonResponse;

class UpdateUserController
{
    /**
     * @param UpdateUserRequest $request
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request)
    {
        $user = auth()->user();
        // AuthServiceProvider
        if (!$user->can('update', $user)) {
            return response()->json([
                'message' => 'У вас нет прав для обновления профиля'
            ], 403);
        }
        $data = $request->validated();
        $user->update($data);
        return response()->json([
            'message' => 'Данные успешно обновлены',
            'user' => new UserResource($user->fresh()) // свежие данные из БД
        ], 200);
    }
}
