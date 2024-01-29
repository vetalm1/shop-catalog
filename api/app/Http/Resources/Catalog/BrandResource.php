<?php

namespace App\Http\Resources\Catalog;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'products_count' => $this->products_count,
            'image' => $this->getImage('image'),

            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
        ];
    }
}
