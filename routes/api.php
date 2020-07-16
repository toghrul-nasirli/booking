<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Api')->group(function () {
    Route::apiResource('bookables', 'BookableController')->only(['index', 'show']);
    Route::get('bookables/{bookable}/availability', 'BookableAvailabilityController')->name('bookables.availability');
    Route::get('bookables/{bookable}/reviews', 'BookableReviewController')->name('bookables.reviews');
    Route::get('bookables/{bookable}/price', 'BookablePriceController')->name('bookables.price');
    
    Route::get('booking-by-review/{reviewKey}', 'BookingByReviewController')->name('booking-by-review');
    
    Route::apiResource('reviews', 'ReviewController')->only('show', 'store');
   
    Route::post('checkout', 'CheckoutController')->name('checkout');
});
