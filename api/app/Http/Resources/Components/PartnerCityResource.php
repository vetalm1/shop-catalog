<?php

namespace App\Http\Resources\Components;

use Illuminate\Http\Resources\Json\JsonResource;

class PartnerCityResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'city' => $this->city,
            'title' => $this->title,
            'text' => $this->text,
            'coords' => $this->coords ? explode('/', $this->coords) : [],
        ];
    }
}
