<?php

namespace App\Services\Booking;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;

class BookingService implements BookingServiceInterface
{
    use ApiResponses;

    public function createBooking(Request $request): JsonResponse
    {
        try {
            $booking = Booking::create([
                'user_id' => $request->input('user_id'),
                'trip_id' => $request->input('trip_id')
            ]);

            return (new BookingResource($booking))->response();
        } catch (\Throwable $e) {
            report($e);
            return $this->serverErrorMessage(['Server error']);
        }
    }

    public function listBookings(): JsonResponse
    {
        return BookingResource::collection(Booking::paginate())->response();
    }
}
