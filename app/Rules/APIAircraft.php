<?php

namespace App\Rules;

use App\Models\Aircraft\ApprovedAircraft;
use Illuminate\Contracts\Validation\Rule;

class APIAircraft implements Rule
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
        return ApprovedAircraft::where('icao', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You must enter a valid aircraft ICAO code.';
    }
}
