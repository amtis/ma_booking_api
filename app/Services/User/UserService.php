<?php

namespace App\Services\User;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponses;

class UserService implements UserServiceInterface
{
    use ApiResponses;

    public function listUsers(): JsonResponse
    {
        $users = User::select(
            'id',
            'first_name',
            'last_name',
            'email'
        )->paginate();

        return UserResource::collection($users)->response();
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

    public function updateUser($request): JsonResponse
    {
        try {
            $user = User::where('id', $request->input('user_id'))->first();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            if ($request->has('password')) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->save();
            return (new UserResource($user))->response();
        } catch (\Throwable $e) {
            report($e);
            return $this->serverErrorMessage(['Server error']);
        }
    }

    public function deleteUser($request): JsonResponse
    {
        try {
            User::where('id', $request->input('user_id'))->delete();
            return $this->generalOkMessage('User was deleted!');
        } catch (\Throwable $e) {
            report($e);
            return $this->serverErrorMessage(['Server error']);
        }
    }
}
