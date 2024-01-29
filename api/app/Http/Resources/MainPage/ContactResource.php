<?php

namespace App\Http\Resources\MainPage;

use App\Models\Contact;
use Illuminate\Http\Resources\Json\JsonResource;

/**@mixin Contact*/
class ContactResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'place' => $this->place,
            'value' => $this->value,
            'title' => $this->title,
        ];
    }
}
