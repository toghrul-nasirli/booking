<?php

use App\Booking;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Booking::class, function (Faker $faker) {
    $from = Carbon::instance($faker->dateTimeBetween('-1 months', '+1 months'));
    $to = (clone $from)->addDays(random_int(0, 14));

    return [
        'from' => $from,        
        'to' => $to,        
        'price' => random_int(200, 5000),        
    ];
});
