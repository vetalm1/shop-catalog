<?php

namespace App\Http\Resources\Catalog;

use App\Models\PropertyValue;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PropertyValue */
class PropertyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'group' => $this->property?->propertyGroup?->name,
            'group_order' => $this->property?->propertyGroup?->order_column,
            'name' => $this->property?->name,
            'more_info' => $this->property?->more_info,
            'is_main' => $this->property?->is_main,
            'value' => $this->value,
        ];
    }
}
