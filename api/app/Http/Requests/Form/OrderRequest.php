<?php

namespace App\Http\Requests\Form;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;


class OrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required|max:255',
            'name' => 'required|max:255',
            'company_name' => 'sometimes|max:255',
            'phone' => ['required', new PhoneRule()],
            'email' => 'sometimes|max:255',
            'product_id' => 'sometimes',
            'quantity' => 'sometimes',
            'product_name' => 'required',
            'comment' => 'sometimes',
        ];
    }

    public function getFieldsToFill(): array
    {
        return [
            'type' => $this->type,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'product_name' => $this->product_name,
            'name' => $this->name,
            'company_name' => $this->company_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'comment' => $this->comment,
        ];
    }
}
