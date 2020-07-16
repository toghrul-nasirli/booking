<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            BookableSeeder::class,
            BookingSeeder::class,
            ReviewSeeder::class
        ]);
    }
}
