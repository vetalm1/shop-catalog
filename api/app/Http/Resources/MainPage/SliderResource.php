<?php

namespace App\Http\Resources\MainPage;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'title' => $this->title,
            'slides' => SlideResource::collection($this->slides),
        ];
    }
}
