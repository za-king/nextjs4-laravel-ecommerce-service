<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name,
            "description" => $this->description,
            "image_url" => $this->image_url,
            "price" => $this->price,
            "stock" => $this->stock,
            "category_id" => $this->category_id,
        ];
    }
}
