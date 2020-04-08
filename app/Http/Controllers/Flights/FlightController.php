<?php

namespace App\Http\Controllers\Flights;

use App\Models\Users\User;
use Illuminate\Http\Request;
use App\Models\Flights\Flight;
use App\Notifications\NewRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Flights\MasterFlight;
use Illuminate\Support\Facades\Auth;
use App\Models\Flights\ArchivedFlight;
use App\Models\Users\UserNotification;
use App\Notifications\RequestAccepted;
use Illuminate\Support\Facades\Notification;

class FlightController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:user']);

        $this->middleware(['flight_role:requestee'])->only(['generateCode', 'edit', 'update', 'destroy']);
        //$this->middleware(['flight_role:acceptee'])->only(['accept']);
        $this->middleware(['flight_role:guest'])->only(['accept']);
    }

    /**
     * Display all flights which a user can accept
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // select flights the user can accept
        $acceptableRequests =   Flight::
                                  where('requestee_id', '<>', Auth::user()->id)
                                ->where('public', '=', 1)
                                ->whereNull('acceptee_id')
                                ->get();

        return view('flights.index', [
            'title'     => 'All Requests',
            'flights'   => $acceptableRequests
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'departure' => 'required|size:4|airport',
            'arrival' => 'required|size:4|airport',
            'aircraft' => 'required|size:4|aircraft'
        ]);

        $flight = new Flight();

        $flight->fill([
            'departure' => strtoupper($request->departure),
            'arrival'   => strtoupper($request->arrival),
            'aircraft'  => strtoupper($request->aircraft)
        ]);
        $flight->requestee_id = Auth::user()->id;

        // if request is private, generate a code
        $flight->public = $request->public == 'on';
        if (!$flight->public)
            $flight->code = Flight::generatePublicId();

		$flight->save();

		$users = UserNotification::whereJsonContains('new_request->airports', $request->departure)
								->orWhereJsonContains('new_request->airports', $request->arrival)
								->orWhereJsonContains('new_request->aircrafts', $request->airport)
								->with('user')
								->get()
								->pluck('user')
								->flatten();

		Notification::send($users, new NewRequest(Auth::user(), $flight));	

        return redirect()->route('flights.show', [$flight]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Flights\MasterFlight $flight
     * @return \Illuminate\Http\Response
     */
    public function show(Flight $flight)
    {
        return view('flights.show', ['flight' => $flight]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Flights\Flight $flight
     * @return \Illuminate\Http\Response
     */
    public function edit(Flight $flight)
    {
        return view('flights.edit', ['flight' => $flight]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Flights\Flight $flight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flight $flight)
    {
        $flight->fill([
            'departure' => $request->departure,
            'arrival'   => $request->arrival,
            'aircraft'  => $request->aircraft
        ]);

        $flight->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Flights\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flight $flight)
    {
        // TODO
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
        $archivedFlights = ArchivedFlight::where('requestee_id', '=', Auth::user()->id)
                                         ->orWhere('acceptee_id', '=', Auth::user()->id)
                                         ->get();

        return view('flights.user', [
            'openRequests'      => $openRequests,
            'acceptedRequests'  => $acceptedRequests,
            'archivedFlights' => $archivedFlights
        ]);
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
                ->where('public', 1)
                ->where(function ($q) use ($query){
                    $q->where('departure', 'like', '%'.$query.'%')
                    ->orWhere('arrival', 'like', '%'.$query.'%')
                    ->orWhere('aircraft', 'like', '%'.$query.'%')
                    ->where('public', 1);
                })
                ->orderBy('id', 'asc')
                ->get();
        }
        else
        {
            $data =
                Flight::get()
                ->where('public', 1)
                ->sortBy('id');
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

        // send notification

        $requestee = User::where('id', $flight->requestee_id)->first();
        $requestee->notify(new RequestAccepted(Auth::user(), $flight));

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
