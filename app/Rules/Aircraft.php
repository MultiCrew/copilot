<?php

namespace App\Rules;

use App\Models\Aircraft\ApprovedAircraft as ApprovedAircraftModel;
use Illuminate\Contracts\Validation\Rule;

class Aircraft implements Rule
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
        return ApprovedAircraftModel::where('id', $value)->exists();
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
