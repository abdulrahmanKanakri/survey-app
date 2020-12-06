<?php

namespace App\Rules;

use App\Enums\MaritalStatus;
use Illuminate\Contracts\Validation\Rule;

class MaritalStatusRule implements Rule
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
        return in_array($value, MaritalStatus::getConstants());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid marital status';
    }
}
