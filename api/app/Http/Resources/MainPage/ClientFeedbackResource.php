<?php

namespace App\Http\Resources\MainPage;

use App\Models\ClientFeedback;
use Illuminate\Http\Resources\Json\JsonResource;

/**@mixin ClientFeedback*/
class ClientFeedbackResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'company_name' => $this->company_name,
            'company_title' => $this->company_title,
            'short_text' => $this->short_text,
            'text' => $this->text,

            'image' => $this->getImage('image'),
        ];
    }
}
