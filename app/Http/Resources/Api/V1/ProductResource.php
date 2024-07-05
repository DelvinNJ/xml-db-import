<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'entity_id' => $this->entity_id,
            'category_name' => $this->category_name,
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'short_desc' => $this->short_desc,
            'price' => $this->price,
            'link' => $this->link,
            'image' => $this->image,
            'brand' => $this->brand,
            'rating' => $this->rating,
            'caffeine_type' => $this->caffeine_type,
            'count' => $this->count,
            'flavored' => $this->flavored,
            'seasonal' => $this->seasonal,
            'in_stock' => $this->in_stock,
            'facebook' => $this->facebook,
            'is_kcup' => $this->is_kcup,
        ];
    }
}
