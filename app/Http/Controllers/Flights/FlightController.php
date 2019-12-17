<?php

namespace App\Http\Controllers\Flights;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Flights\FlightRequest;

class FlightController extends Controller
{
    /**
     * Display table of flights
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('flights.index'//,
            //['flights' => FlightRequest::all()]
        );
    }

    /**
     * Search the database for flights, based on a query parameter if given in the request
     * Method can be called either in ajax or PHP, see below
     *
     * @param      \Illuminate\Http\Request     $request
     *                                              ->ajax()    If JSON array required
     *                                                          Otherwise PHP array returned
     * @return     JSON Array | PHP array       Array of flights found based on request
     */
    public function search(Request $request)
    {
        $output = '';
        $query = $request->get('query');

        if($query != '')
        {
            $data =
                DB::table('flight_requests')
                ->where('departure', 'like', '%'.$query.'%')
                ->orWhere('arrival', 'like', '%'.$query.'%')
                ->orWhere('aircraft', 'like', '%'.$query.'%')
                ->orderBy('id', 'asc')
                ->get();
        }
        else
        {
            $data =
                DB::table('flight_requests')
                ->orderBy('id', 'asc')
                ->get();
        }

        if($request->ajax())
            echo json_encode($data);
        else
            return $data;
    }
}

