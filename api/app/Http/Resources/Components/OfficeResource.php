<?php

namespace App\Http\Resources\Components;

use Illuminate\Http\Resources\Json\JsonResource;

class OfficeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'short_title' => $this->short_title,
            'text' => $this->text,
            'emails' => $this->emails,
            'address_title' => $this->address_title,
            'address' => $this->address,
            'phone' => $this->phone,
            'opening_hours' => $this->opening_hours,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'image' => $this->getImage('image'),
            'flag_image' => $this->getImage('flag_image'),
            'image_gallery' => $this->getImages('image-gallery'),
        ];
    }
}
