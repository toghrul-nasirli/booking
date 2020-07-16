<?php

use App\Bookable;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$suffix = [
    'Cottages',
    'Houses',
    'Cheap Houses',
    'Villas',
    'Luxury Villas',
    'Rooms',
    'Cheap Rooms',
    'Luxury Rooms',
    'Fancy Rooms',
];

$factory->define(Bookable::class, function (Faker $faker) use ($suffix) {
    return [
        'title' => $faker->city . ' ' . Arr::random($suffix),
        'description' => $faker->text(),
        'price' => random_int(15, 600)
    ];
});
