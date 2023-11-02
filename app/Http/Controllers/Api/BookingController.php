<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Services\Booking\BookingServiceInterface;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    public function __construct(public BookingServiceInterface $bookingService){}

    public function index(): JsonResponse
    {
        return $this->bookingService->listBookings();
    }

    public function store(BookingRequest $request): JsonResponse
    {
        return $this->bookingService->createBooking($request);
    }
}
