<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'public' => 'required|boolean'
        ];
    }
}
