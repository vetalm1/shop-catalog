<?php

namespace App\Http\Resources\Catalog;

use App\Models\ProductAddition;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ProductAddition */

class ProductAdditionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'images_title' => $this->images_title,
            'description' => $this->description,
            'other_description' => $this->other_description,
            'images' => $this->getImages('image-gallery'),
        ];
    }
}
