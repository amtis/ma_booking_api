<?php

namespace App\Services\User;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function listUsers(): JsonResponse
    {
        $users = User::select(
            'id',
            'first_name',
            'last_name',
            'email'
        )->paginate();

        return (new UserCollection($users))->response();
    }

    public function showUser(int $userId): JsonResponse
    {
        $user = User::where('id', $userId)->firstOrFail();
        return (new UserResource($user))->response();
    }

    public function createUser($request): ?object
    {
        try {
            return User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }

    public function updateUser($request): bool
    {
        $user = User::where('id', $request->input('user_id'))->firstOrFail();
        try {
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->save();
            return true;
        } catch (\Throwable $e) {
            report($e);
            return false;
        }
    }

    public function deleteUser($request): bool
    {
        $user = User::where('id', $request->input('user_id'))->firstOrFail();
        try {
            $user->delete();
            return true;
        } catch (\Throwable $e) {
            report($e);
            return false;
        }
    }
}
