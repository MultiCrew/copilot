<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam departure string[] An array of all the departure ICAO codes, leave blank for no preference. Example: ["EGLL", "EGKK"]
 * @bodyParam arrival string[] An array of all the arrival ICAO codes, leave blank for no preference. No-example
 * @bodyParam aircraft string required An ICAO code for the requested aircraft. Example: A320
 * @bodyParam public boolean required Whether the request should be public or not. Example: true
 * @bodyParam callback string The full URL to receive notifications for this request. Example: example.com
 */
class StoreFlightRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'departure' => 'required_without:arrival|array',
            'arrival' => 'required_without:departure|array',
            'departure.*' => 'required|size:4|airport|string',
            'arrival.*' => 'required|size:4|airport|string',
            'aircraft' => 'required|apiAircraft|string',
            'public' => 'required|boolean',
            'callback' => 'nullable|url'
        ];
    }
}
