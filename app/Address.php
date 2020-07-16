<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = ['id'];

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }
}
