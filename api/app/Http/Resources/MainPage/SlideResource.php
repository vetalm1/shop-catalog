<?php

namespace App\Http\Resources\MainPage;

use Illuminate\Http\Resources\Json\JsonResource;

class SlideResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'button_text' => $this->button_text,
            'button_link' => $this->button_link,
            'button_background_color' => $this->button_background_color,
            'button_text_color' => $this->button_text_color,
            'button_frame_color' => $this->button_frame_color,
            'image' => $this->getImage('image'),
        ];
    }
}
