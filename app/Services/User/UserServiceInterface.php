<?php

namespace App\Services\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function listUsers(): JsonResponse;

    public function showUser(int $userId): JsonResponse;

    public function createUser(Request $request): ?object;

    public function updateUser(Request $request): bool;

    public function deleteUser(Request $request): bool;
}
