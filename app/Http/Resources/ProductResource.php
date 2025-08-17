<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'slug'    => $this->slug,
            'price'   => (float) $this->base_price,
            'stock'   => (int) $this->stock,
            'rating'  => [
                'avg'   => (float) $this->rating_avg,
                'count' => (int) $this->rating_count,
            ],
            'category'=> $this->whenLoaded('category', fn() => [
                'id'   => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ]),
            'created_at' => optional($this->created_at)->toISOString(),
        ];
    }
}
