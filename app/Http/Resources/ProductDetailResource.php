<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'slug'         => $this->slug,
            'name'         => $this->name,
            'description'  => $this->description,
            'category'     => [
                'id'   => $this->category?->id,
                'name' => $this->category?->name,
                'slug' => $this->category?->slug,
            ],
            'base_price'   => (float) $this->base_price,
            'stock'        => $this->stock,
            'rating_avg'   => (float) $this->rating_avg,
            'rating_count' => $this->rating_count,
            'variants'     => $this->whenLoaded('variants', function () {
                return $this->variants->map(fn($v) => [
                    'id'           => $v->id,
                    'sku'          => $v->sku,
                    'option_name'  => $v->option_name,
                    'option_value' => $v->option_value,
                    'price'        => $v->price !== null ? (float) $v->price : null,
                    'stock'        => $v->stock,
                ]);
            }),
            'reviews'      => ReviewResource::collection($this->whenLoaded('reviews')),
        ];
    }
}
