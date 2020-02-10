<?php

namespace App\Rules;

use App\Models\Airports\Airport as AirportModel;
use Illuminate\Contracts\Validation\Rule;

class Airport implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
       return AirportModel::where('icao', $value)->exists(); 
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You must enter a valid airport ICAO code.';
    }
}
