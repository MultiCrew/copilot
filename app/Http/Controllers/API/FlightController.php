<?php

namespace App\Http\Controllers\API;

use App\Models\Users\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aircraft\ApprovedAircraft;
use App\Models\Flights\FlightRequest;

class FlightController extends Controller
{
    /**
     * Search the database for flights, based on a query parameter if given in the request
     * Method can be called either in ajax or PHP, see below
     *
     * @param      \Illuminate\Http\Request     $request
     * @return     JSON Array | PHP array       Array of flights found based on request
     */
    public function search(Request $request)
    {
        $query = '';
        if ($request->path() == 'api/search' && $request->get('query')) {
            $query = $request->get('query');
        }
        if ($query != '') {
            $aircraft = preg_grep('/^[A-Z]{1,}[0-9]{1,}[A-Z]?$/i', $query);

            $aircraftArray = ApprovedAircraft::where('approved', 1)->whereIn('icao', $aircraft)->pluck('id')->all();

            $data = FlightRequest::where('public', 1)
            ->where(function ($q) use ($query) {
                foreach ($query as $apt) {
                    $q->whereJsonContains('departure', $apt);
                    $q->orWhereJsonContains('arrival', $apt);
                }
            })
            ->orWhereIn('aircraft_id', $aircraftArray)
            ->whereNull('acceptee_id')
            ->orderBy('id', 'asc')
            ->get()
            ->load('aircraft', 'requestee');
            
        } else {
            $data =
                FlightRequest::get()
                ->where('public', 1)
                ->whereNull('acceptee_id')
                ->sortBy('id')
                ->load('aircraft', 'requestee');
        }
        if ($request->ajax())
            return json_encode($data);
        else
            return $data;
    }

    /**
     * Returns a list of all approved aircraft
     * 
     * @param      \Illuminate\Http\Request     $request
     * @return     JSON Array                   Array of approved aircraft
     */
    public function aircraft(Request $request)
    {
        $aircraftArray = ApprovedAircraft::where('approved', true)->get();

        if ($request->ajax())
            return json_encode($aircraftArray);
        else
            return $aircraftArray;
    }

    /**
     * Create a new flight
     *
     * @param      \Illuminate\Http\Request     $request
     * @return     JSON Array | PHP array       Array of flights found based on request
     */
    public function store(Request $request)
    {
        $flight = new FlightRequest();
        $user = User::where('discord_id', $request->discord_id)->first();
        if (!$user) {
            return $user;
        }

        $flight->fill([
            'departure' => $request->departure,
            'arrival'   => $request->arrival,
            'aircraft'  => $request->aircraft
        ]);
        $flight->requestee_id = $user->id;
        $flight->public = true;
        $flight->save();

        $flight = $flight->fresh();
        return $flight;
    }
}
