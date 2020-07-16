<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookableIndexResource;
use App\Http\Resources\BookableShowResource;
use Illuminate\Http\Request;

class BookableController extends Controller
{
    public function index()
    {
        $bookables = Bookable::all();

        return BookableIndexResource::collection($bookables);
    }

    public function show(Bookable $bookable)
    {
        return new BookableShowResource($bookable);
    }
}
