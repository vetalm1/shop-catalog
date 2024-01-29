<?php

namespace App\Http\Requests\Form;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class BrandsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sort' => 'sometimes|max:255',
            'brand' => 'sometimes|max:255',
        ];
    }
}
