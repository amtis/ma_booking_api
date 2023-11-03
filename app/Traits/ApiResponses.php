<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as Response;

trait ApiResponses
{
    public function generalOkMessage(string $message, int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json($message, $status);
    }

    public function sendAccessToken(string $token, string $type = 'Bearer'): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => $type,
        ]);
    }

    public function generalErrorMessage(array $errors, int $status = Response::HTTP_NOT_FOUND): JsonResponse
    {
        return response()->json($errors, $status);
    }

    public function serverErrorMessage(array $errors, int $status = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return $this->generalErrorMessage($errors, $status);
    }

    public function validationErrorMessage(array $errors, int $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return $this->generalErrorMessage($errors, $status);
    }

    public function unauthenticatedErrorMessage(array $errors, int $status = Response::HTTP_UNAUTHORIZED): JsonResponse
    {
        return $this->generalErrorMessage($errors, $status);
    }

}
