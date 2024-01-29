<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ValidPasswordRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return Hash::check($value, Auth::user()->password);
    }

    public function message(): string
    {
        return 'Wrong password';
    }
}
