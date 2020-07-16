<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookableReviewIndexResource;
use Illuminate\Http\Request;

class BookableReviewController extends Controller
{
    public function __invoke(Bookable $bookable)
    {
        return BookableReviewIndexResource::collection($bookable->reviews()->latest()->get());
    }
}
