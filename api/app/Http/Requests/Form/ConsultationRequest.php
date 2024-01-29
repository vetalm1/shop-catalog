<?php

namespace App\Http\Requests\Form;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class ConsultationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required|max:255',
            'name' => 'required|max:255',
            'phone' => ['required', new PhoneRule()],
        ];
    }

    public function getFieldsToFill(): array
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'phone' => $this->phone,
        ];
    }
}
