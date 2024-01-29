<?php

namespace App\Http\Resources\Product;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Product */

class BaseProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'art' => $this->art,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'balance' => $this->balance,
            'image' => $this->getImage('image', 'medium'),
        ];
    }
}
