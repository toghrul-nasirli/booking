<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookableReviewIndexResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'rating' => $this->rating,
            'content' => $this->content,
            'created_at' => $this->created_at
        ];
    }
}
