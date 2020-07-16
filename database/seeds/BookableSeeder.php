<?php

use App\Bookable;
use Illuminate\Database\Seeder;

class BookableSeeder extends Seeder
{
    public function run()
    {
        factory(Bookable::class, 100)->create();
    }
}
