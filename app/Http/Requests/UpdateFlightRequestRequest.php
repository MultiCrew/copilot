<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use App\Models\Flights\FlightRequest;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\UnauthorizedException;

class UpdateFlightRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::id() == FlightRequest::findOrFail($this->route('request'))->requestee_id;
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

    protected function failedAuthorization()
    {
        throw new UnauthorizedException('The autheticated user did not make this request');
    }
}
