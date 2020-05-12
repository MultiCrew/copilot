<?php
namespace App\Http\Traits;

use App\Models\Flights\FlightRequest;
use Illuminate\Support\Facades\Auth;
use App\Notifications\RequestAccepted;

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

        return $flight;
    }
}
