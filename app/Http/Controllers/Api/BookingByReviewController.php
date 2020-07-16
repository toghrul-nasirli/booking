<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingByReviewShowResource;
use Illuminate\Http\Request;

class BookingByReviewController extends Controller
{
    public function __invoke($reviewKey)
    {
        $booking = Booking::findByReviewKey($reviewKey);
        
        return $booking ? new BookingByReviewShowResource($booking) : abort(404);
    }
}
