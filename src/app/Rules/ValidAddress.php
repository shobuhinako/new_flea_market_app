<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidAddress implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^[ぁ-んァ-ン一-龥0-9０-９ー-]+$/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '住所は漢字、ひらがな、カタカナ、数字のみでなければなりません。';
    }
}
