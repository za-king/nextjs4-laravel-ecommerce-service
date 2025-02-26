<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "comment" => $this->comment,
            "ratting" => $this->ratting,
            "user_id" => $this->user_id,
            "product_id" => $this->product_id,

        ];
    }
}
