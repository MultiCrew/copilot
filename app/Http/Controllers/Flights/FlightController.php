<?php

namespace App\Http\Controllers\Flights;

use \Auth as Auth;
use Illuminate\Http\Request;
use App\Models\Flights\Flight;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FlightController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'search');
    }
    
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
                DB::table('flights')
                ->where('departure', 'like', '%'.$query.'%')
                ->orWhere('arrival', 'like', '%'.$query.'%')
                ->orWhere('aircraft', 'like', '%'.$query.'%')
                ->orderBy('id', 'asc')
                ->get();
        }
        else
        {
            $data =
                DB::table('flights')
                ->orderBy('id', 'asc')
                ->get();
        }

        if($request->ajax())
            echo json_encode($data);
        else
            return $data;
    }

    /**
     * Returns the form for adding a new flight to the database
     *
     * @return     View     Form to make a new flight
     */
    public function create()
    {
        return view('flights.create');
    }

    /**
     * Create a new flight
     *
     * @param      \Illuminate\Http\Request     $request
     * @return     JSON Array | PHP array       Array of flights found based on request
     */
    public function store(Request $request)
    {
        $flight = new Flight();

        $flight->fill([
            'departure' => $request->departure,
            'arrival'   => $request->arrival,
            'aircraft'  => $request->aircraft
        ]);
        $flight->requestee_id = Auth::user()->id;
        $flight->public = ($request->public == 'on') ? 1 : 0;
        $flight->save();

        return view('flights.index');
    }

    /**
     * Generate a code.
     *
     * @param \App\Models\Flights\Flight $flight
     *
     * @return \Illuminate\Http\Response
     */
    public function generateCode(Flight $flight)
    {
        $flight->code = Flight::generatePublicId();
        $flight->save();
        return redirect()->back();
    }
}

