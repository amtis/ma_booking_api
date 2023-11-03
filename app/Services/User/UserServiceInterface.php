<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function listUsers(): JsonResponse;

    public function showUser(int $userId): JsonResponse;

    public function createUser(Request $request): ?object;

    public function updateUser(Request $request): JsonResponse;

    public function deleteUser(Request $request): JsonResponse;

    public function createAccessToken(?object $user, ?string $email = ''): string;
}
