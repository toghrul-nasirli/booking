<?php

use App\Bookable;
use App\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        Bookable::all()->each(function(Bookable $bookable){
            $reviews = factory(Review::class, random_int(5, 30))->make();
            $bookable->reviews()->saveMany($reviews);
        });
    }
}
