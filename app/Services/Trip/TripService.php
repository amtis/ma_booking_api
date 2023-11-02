<?php

namespace App\Services\Trip;

use App\Http\Resources\TripResource;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;

class TripService implements TripServiceInterface
{
    use ApiResponses;

    public function listTrips(array $params): JsonResponse
    {
        $orderBy = ['id', 'asc'];
        if (!empty($params['order_by'])) {
            $orderType = $params['order_type'] ?? 'asc';
            $orderBy = [$params['order_by'], $orderType];
        }

        $trips = Trip::where(function ($q) use ($params) {
            if (!empty($params['search'])) {
                $q->where('title', 'LIKE', '%'.$params['search'].'%');
            }

            if (!empty($params['location'])) {
                $q->where('location', $params['location']);
            }

            if (!empty($params['price_from'])) {
                $q->where('price', '>=', $params['price_from']);
            }

            if (!empty($params['price_to'])) {
                $q->where('price', '<=', $params['price_to']);
            }
        })->orderBy($orderBy[0], $orderBy[1])->paginate();

        return TripResource::collection($trips)->response();
    }

    public function showTrip(string $slug): JsonResponse
    {
        $trip = Trip::where('slug', $slug)->firstOrFail();
        return (new TripResource($trip))->response();
    }

    public function createTrip(Request $request): JsonResponse
    {
        try {
            $trip = Trip::create([
                'slug' => $request->input('slug'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'location' => $request->input('location'),
                'price' => $request->input('price'),
            ]);
            return (new TripResource($trip))->response();
        } catch (\Throwable $e) {
            report($e);
            return $this->serverErrorMessage(['Server error']);
        }
    }

    public function updateTrip(Request $request): JsonResponse
    {
        try {
            $trip = Trip::where('id', $request->input('id'))->firstOrFail();
            $trip->update([
                'slug' => $request->input('slug'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'location' => $request->input('location'),
                'price' => $request->input('price'),
            ]);
            return (new TripResource($trip))->response();
        } catch (\Throwable $e) {
            report($e);
            return $this->serverErrorMessage(['Server error']);
        }
    }

    public function deleteTrip(Request $request): JsonResponse
    {
        try {
            Trip::where('id', $request->input('id'))->delete();
            return $this->generalOkMessage('Trip was deleted!');
        } catch (\Throwable $e) {
            report($e);
            return $this->serverErrorMessage(['Server error']);
        }
    }
}
