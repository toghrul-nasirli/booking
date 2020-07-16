<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Controllers\Controller;

class BookablePriceController extends Controller
{
    public function __invoke(Bookable $bookable)
    {
        $data = request()->validate([
            'from' => ['required', 'date_format:Y-m-d', 'after_or_equal:now'],
            'to' => ['required', 'date_format:Y-m-d', 'after_or_equal:from'],
        ]);

        return response()->json([
            'data' => $bookable->priceFor($data['from'], $data['to'])
        ]);
    }
}
