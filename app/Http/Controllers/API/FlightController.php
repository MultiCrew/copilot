<?php

namespace App\Http\Controllers\API;

use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
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
            $data =
                FlightRequest::where('public', 1)
                ->where(function ($q) use ($query) {
                    $q->whereIn('departure', $query);
                    $q->orWhereIn('arrival', $query);
                    $q->orWhereIn('aircraft_id', $query);
                })
                ->whereNull('acceptee_id')
                ->orderBy('id', 'asc')
                ->get()
                ->load('aircraft');
        } else {
            $data =
                FlightRequest::get()
                ->where('public', 1)
                ->whereNull('acceptee_id')
                ->sortBy('id')
                ->load('aircraft');
        }
        if ($request->ajax())
            return json_encode($data);
        else
            return $data;
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
