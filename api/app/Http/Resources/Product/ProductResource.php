<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Catalog\PropertyResource;
use App\Http\Resources\Components\IdNameSlugImageResource;

class ProductResource extends BaseProductResource
{
    public function toArray($request): array
    {
        $parent = parent::toArray($request);

        return  array_merge($parent, [
            'brand' => $this->brand ? new IdNameSlugImageResource($this->brand) : null,
            'title' => $this->title,
            'description' => $this->description,
            'hidden_description' => $this->hidden_description,
            'properties' => PropertyResource::collection($this->propertyValues),
            'images' => $this->getImages('image-gallery', 'medium'),
            'video' => $this->getFile('video'),

            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
        ]);
    }
}
