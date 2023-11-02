<?php

namespace App\Services\Booking;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface BookingServiceInterface
{
    public function createBooking(Request $request): JsonResponse;

    public function listBookings(): JsonResponse;
}
