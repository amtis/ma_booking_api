<?php

namespace App\Services\Trip;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface TripServiceInterface
{

    public function listTrips(array $params): JsonResponse;

    public function showTrip(string $slug): JsonResponse;

    public function createTrip(Request $request): JsonResponse;

    public function updateTrip(Request $request): JsonResponse;

    public function deleteTrip(Request $request): JsonResponse;
}
