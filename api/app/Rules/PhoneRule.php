<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneRule implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match("/\+[0-9]\([0-9]{3}\)[0-9]{3}-[0-9]{2}-[0-9]{2}/", $value);
    }

    public function message()
    {
        return 'Invalid :attribute format';
    }
}
