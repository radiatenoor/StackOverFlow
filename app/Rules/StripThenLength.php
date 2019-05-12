<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StripThenLength implements Rule
{
    public $strLength;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($length)
    {
        $this->strLength = $length;
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
        $sanitize = strip_tags($value);
        return strlen($sanitize) > $this->strLength;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be at least '.$this->strLength.' character';
    }
}
