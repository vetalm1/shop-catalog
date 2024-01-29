<?php

namespace App\Http\Requests\Auth;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $phone
 * @property mixed $password
 * @property mixed $code
 */
class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'phone' => ['required', new PhoneRule()],
            'password' => 'nullable|string',
        ];
    }
}
