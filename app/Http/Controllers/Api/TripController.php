<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddEditTripRequest;
use App\Http\Requests\SearchTripRequest;
use App\Services\Trip\TripServiceInterface;
use Illuminate\Http\JsonResponse;

class TripController extends Controller
{
    public function __construct(public TripServiceInterface $tripService){}

    public function index(SearchTripRequest $request): JsonResponse
    {
        return $this->tripService->listTrips(
            $request->only(
                'order_by',
                'order_type',
                'price_from',
                'price_to',
                'search',
                'location'
            )
        );
    }

    public function show(string $slug): JsonResponse
    {
        return $this->tripService->showTrip($slug);
    }

    public function store(AddEditTripRequest $request): JsonResponse
    {
        return $this->tripService->createTrip($request);
    }

    public function update(AddEditTripRequest $request): JsonResponse
    {
        return $this->tripService->updateTrip($request);
    }

    public function destroy(AddEditTripRequest $request): JsonResponse
    {
        return $this->tripService->deleteTrip($request);
    }
}
