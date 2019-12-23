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
        $this->middleware('auth');

        $this->middleware(['flight_role:requestee'])->only(['generateCode']);
        $this->middleware(['flight_role:acceptee'])->only(['join']);
    }

    /**
     * Display all flights which a user can accept
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // select flights where requestee_id is NOT the authed user
        $acceptableRequests =   Flight::
                                  where('requestee_id', '<>', Auth::user()->id)
                                ->where('public', '=', 1)
                                ->whereNull('acceptee_id')
                                ->get();

        return view('flights.index', [
            'title'     => 'All Requests',
            'flights'   => $acceptableRequests
            ]
        );
    }

    /**
     * Display all a user's open requests
     *
     * @return \Illuminate\Http\Response
     */
    public function userRequests()
    {
        // select flights where requestee_id IS the authed user
        $userRequests = Flight::
                          where('requestee_id', '=', Auth::user()->id)
                        ->whereNull('acceptee_id')
                        ->get();

        return view('flights.index', [
            'title'     => 'My Requests',
            'flights'   => $userRequests
            ]
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
        $flight->public = $request->public == 'on';
        if($request->public != 'on') {
            $flight->code = Flight::generatePublicId();
        }
        $flight->save();

        return view('flights.show', ['flight' => $flight]);
    }

    /**
     * Accept a request
     *
     * @param string $id
     */
    public function accept(string $id)
    {
        $flight = Flight::where('id', $id)->first();

        if($flight == null) abort(404);
        if($flight->isRequestee(Auth::user()) || $flight->isAcceptee(Auth::user()))
            return redirect()->route('flights.info', ['flight' => $flight]);

        $flight->acceptee_id = Auth::user()->id;
        //$flight->save();
        //return view('flights.', ['flight' => $flight]);
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

