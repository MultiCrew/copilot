<?php
namespace App\Http\Traits;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Flights\FlightRequest;
use App\Notifications\RequestAccepted;
use App\Http\Resources\Flights\RequestResource;

trait FlightJoinTrait {

    public function accept(FlightRequest $flight)
    {
        // if the user is the requestee or has already accepted the flight
        if( $flight->isRequestee(Auth::user()) || $flight->isAcceptee(Auth::user()) )
        {   // redirect them to the flight
            return  redirect()
                    ->route('flights.show', $flight->id)
                    ->withErrors(['You have already accepted this request!']);
        }

        // accept the flight
        $flight->acceptee_id = Auth::user()->id;
        $flight->save();

        // send notification

        $requestee = $flight->requestee;
        $requestee->notify(new RequestAccepted(Auth::user(), $requestee, $flight));

        try {
            if ($flight->callback) {
                $client = new Client();
                $client->post($flight->callback, [
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ],
                    'body' => json_encode(new RequestResource($flight)),
                ]);
            }
        } catch (Exception $e) {
            Log::error('Attempted to send request to callback url', [
                'url' => $flight->callback,
                'message' => $e->getMessage(),
                'error' => $e
            ]);
        }

        return $flight;
    }
}
