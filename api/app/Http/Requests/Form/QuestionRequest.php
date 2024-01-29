<?php

namespace App\Http\Requests\Form;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;


class QuestionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required|max:255',
            'name' => 'required|max:255',
            'phone' => ['required', new PhoneRule()],
            'email' => 'sometimes|max:255',
            'question' => 'sometimes',
        ];
    }

    public function getFieldsToFill(): array
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'question' => $this->question,
        ];
    }
}
