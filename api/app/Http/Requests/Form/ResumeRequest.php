<?php

namespace App\Http\Requests\Form;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class ResumeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'sometimes|max:255',
            'vacancy_id' => 'required|max:255',
            'upload_file' => 'required',
        ];
    }
}
