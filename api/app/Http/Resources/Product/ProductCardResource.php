<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Catalog\PropertyResource;
use App\Http\Resources\Components\IdNameSlugResource;

class ProductCardResource extends BaseProductResource
{
    public function toArray($request): array
    {
        $parent = parent::toArray($request);

        return  array_merge($parent, [
            'is_in_stock' => $this->isInStock(),
            'brand' => $this->brand ? new IdNameSlugResource($this->brand) : null,
            'properties' => PropertyResource::collection($this->propertyValues),
        ]);
    }
}
