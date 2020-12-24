<?php

namespace App\Http\Controllers\Flights;

use App\Http\Controllers\Controller;
use App\Models\Flights\FlightRequest;
use App\Models\Flights\ArchivedFlight;
use App\Models\Flights\FlightPlan;
use App\Models\Airports\Airport;

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
    public function store($flight)
    {
        $flight = FlightRequest::find($flight);
        if (empty($flight)) {
            $recentFlight = ArchivedFlight::where('requestee_id', Auth::user()->id)
                                        ->orWhere('acceptee_id', Auth::user()->id)
                                        ->orderBy('created_at', 'desc')
                                        ->first();
            return redirect()->route('flights.archive.show', $recentFlight);
        }
        $archived = new ArchivedFlight();

        $archived->fill([
            'departure'         => $flight->departure[0],
            'arrival'           => $flight->arrival[0],
            'aircraft_id'      => $flight->aircraft_id,
            'requestee_id'      => $flight->requestee_id,
            'acceptee_id'       => $flight->acceptee_id,
        ]);

        $archived->save();
        FlightPlan::archive($flight->plan);

        $flight->delete();

        return redirect()->route('flights.archive.show', ['flight' => $archived]);
    }

    public function show(ArchivedFlight $flight)
    {
        return view('flights.show', [
            'type' => 'ArchivedFlight',
            'flight' => $flight,
            'departureAirports' => Airport::where('icao', $flight->departure)->get(),
            'arrivalAirports' => Airport::where('icao', $flight->arrival)->get()
        ]);
    }
}
