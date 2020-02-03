<?php

namespace App\Http\Controllers\Flights;

use App\Http\Controllers\Controller;
use App\Models\Flights\Flight;
use Illuminate\Http\Request;
use Auth;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'departure' => 'required|size:4|airport',
            'arrival' => 'required|size:4|airport',
            'aircraft' => 'required|size:4'
        ]);

        $flight = new Flight();

        $flight->fill([
            'departure' => $request->departure,
            'arrival'   => $request->arrival,
            'aircraft'  => $request->aircraft
        ]);
        $flight->requestee_id = Auth::user()->id;

        // if request is private, generate a code
        $flight->public = $request->public == 'on';
        if (!$flight->public)
            $flight->code = Flight::generatePublicId();

        $flight->save();

        return view('flights.show', ['flight' => $flight]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Flights\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function show(Flight $flight)
    {
        return view('flights.show', ['flight' => $flight]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Flights\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function edit(Flight $flight)
    {
        return view('flights.edit', ['flight' => $flight]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Flights\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flight $flight)
    {
        if ($flight->requestee_id === Auth::user()->id)
        {
            $flight->fill([
                'departure' => $request->departure,
                'arrival'   => $request->arrival,
                'aircraft'  => $request->aircraft
            ]);
            $flight->save();
        }
        else
        {
            // TODO: flight does not belong to user
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Flights\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flight $flight)
    {
        //
    }

    /**
     * Display all a user's accepted and open requests
     *
     * @return \Illuminate\Http\Response
     */
    public function userFlights()
    {
        // select flights where requestee_id IS the authed user and the flights are NOT accepted
        $openRequests = Flight::whereNull('acceptee_id')
                        ->where('requestee_id', '=', Auth::user()->id)
                        ->get();
        // select flights where an involved user IS the authed user and the flights ARE accepted
        $acceptedRequests = Flight::whereNotNull('acceptee_id')
                            ->where(function($query) {
                                $query->where('requestee_id', '=', Auth::user()->id)
                                	  ->orWhere('acceptee_id', '=', Auth::user()->id);
                            })->get();

        return view('flights.user', [
            'openRequests'      => $openRequests,
            'acceptedRequests'  => $acceptedRequests
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
     * Accept a request where the requestee is the authed user
     *
     * @param      \Illuminate\Http\Request     $request
     */
    public function accept(Request $request)
    {
        // get the flight to accept
        $flight = Flight::findOrFail($request->id);

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

        // show the flight
        return redirect()->route('flights.show', ['flight' => Flight::findOrFail($request->id)]);
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
