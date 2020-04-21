<?php

namespace App\Http\Controllers\Flights;

use App\Http\Controllers\Controller;
use App\Models\Flights\FlightRequest;
use App\Models\Flights\ArchivedFlight;
use Illuminate\Http\Request;
use Auth;

class ArchivedFlightController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:user']);
    }

    /**
     * Create a new ArchivedFlight from a FlightRequest
     *
     * @param  \Illuminate\Http\FlightRequest $flight
     * @return \Illuminate\Http\Response
     */
    public function store(FlightRequest $flight)
    {
        $archived = new ArchivedFlight();

        $archived->fill([
            'departure'     => $flight->departure,
            'arrival'       => $flight->arrival,
            'aircraft'      => $flight->aircraft,
            'requestee_id'  => $flight->requestee_id,
            'acceptee_id'   => $flight->acceptee_id,
        ]);

        $archived->save();
        $flight->delete();

        return redirect()->route('flights.show', $archived);
    }

}
