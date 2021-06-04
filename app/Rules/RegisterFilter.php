<?php

namespace App\Rules;

use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class RegisterFilter implements Rule
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
        Validator::extend('olderThan',function($attribute, $value,$parameters)
        {
            $minAge=(!empty($parameters))?(int)$parameters[0]:14;
            //return (new DateTime)->diff(new DateTime($value))->y >=$minAge;
            return Carbon::now()->diff(new Carbon($value))->y >=$minAge;

        });
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The age less than 14';
    }
}
