<?php

namespace App\Http\Controllers\Flights;

use App\Http\Controllers\Controller;
use App\Models\Flights\Flight;
use App\Models\Flights\ArchivedFlight;
use Illuminate\Http\Request;
use Auth;

class ArchivedFlightController extends Controller
{
    /**
     * Create a new ArchivedFlight from a Flight
     *
     * @param  \Illuminate\Http\Flight $flight
     * @return \Illuminate\Http\Response
     */
    public function store(Flight $flight)
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
