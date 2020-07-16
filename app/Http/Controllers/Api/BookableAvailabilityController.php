<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookableAvailabilityController extends Controller
{
    public function __invoke(Bookable $bookable)
    {
        $data = request()->validate([
            'from' => ['required', 'date_format:Y-m-d', 'after_or_equal:now'],
            'to' => ['required', 'date_format:Y-m-d', 'after_or_equal:from']
        ]);

        return $bookable->availableFor($data['from'], $data['to'])
            ? response()->json([])
            : response()->json([], 404);
    }
}
