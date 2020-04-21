<?php

namespace App\Http\Controllers\Flights;

use App\Models\Users\User;
use Illuminate\Http\Request;
use App\Models\Flights\FlightRequest;
use App\Notifications\NewRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Flights\Flight;
use Illuminate\Support\Facades\Auth;
use App\Models\Flights\ArchivedFlight;
use App\Models\Users\UserNotification;
use App\Notifications\RequestAccepted;
use Illuminate\Support\Facades\Notification;
use App\Http\Traits\FlightTrait;

class FlightController extends Controller
{

    use FlightTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'role:user']);

        $this->middleware(['flight_role:participant'])->only(['show']);
        $this->middleware(['flight_role:requestee'])->only(['generateCode', 'edit', 'update', 'destroy']);
        $this->middleware(['flight_role:publicGuest'])->only(['acceptPublic']);
        $this->middleware(['flight_role:privateGuest'])->only(['acceptPrivate']);
    }

    /**
     * Display all flights which a user can accept
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // select flights the user can accept
        $acceptableRequests =   FlightRequest::
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

        $flight = new FlightRequest();

        $flight->fill([
            'departure' => strtoupper($request->departure),
            'arrival'   => strtoupper($request->arrival),
            'aircraft'  => strtoupper($request->aircraft)
        ]);
        $flight->requestee_id = Auth::user()->id;

        // if request is private, generate a code
        $flight->public = $request->public == 'on';
        if (!$flight->public)
            $flight->code = FlightRequest::generateCode();

		$flight->save();

		$users = UserNotification::whereJsonContains('new_request->airports', $request->departure)
								->orWhereJsonContains('new_request->airports', $request->arrival)
                                ->orWhereJsonContains('new_request->aircrafts', $request->airport)
                                ->where('user_id', '!=', Auth::id())
								->with('user')
								->get()
								->pluck('user')
								->flatten();

		Notification::send($users, new NewRequest(Auth::user(), $flight));

        return redirect()->route('flights.show', ['flight' => $flight]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Flights\Flight $flight
     * @return \Illuminate\Http\Response
     */
    public function show(FlightRequest $flight)
    {
        return view('flights.show', ['flight' => $flight]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Flights\FlightRequest $flight
     * @return \Illuminate\Http\Response
     */
    public function edit(FlightRequest $flight)
    {
        return view('flights.edit', ['flight' => $flight]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Flights\FlightRequest $flight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FlightRequest $flight)
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
     * @param  \App\Models\Flights\FlightRequest  $flight
     * @return \Illuminate\Http\Response
     */
    public function destroy(FlightRequest $flight)
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
        $openRequests = FlightRequest::whereNull('acceptee_id')
                        ->where('requestee_id', '=', Auth::user()->id)
                        ->get();
        // select flights where an involved user IS the authed user and the flights ARE accepted
        $acceptedRequests = FlightRequest::whereNotNull('acceptee_id')
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
                FlightRequest::get()
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
    public function acceptPublic(Request $request)
    {
        // get the flight to accept
        $flight = FlightRequest::findOrFail($request->id);

        $flight = $this->accept($flight);

        // show the flight
        return redirect()->route('flights.show', ['flight' => $flight]);
    }

    /**
     * Accept a private request
     *
     * @param \Illuminate\Http\Request $request
     */
    public function acceptPrivate(Request $request)
    {
        $flight = FlightRequest::where('code', $request->code)->first();

        $flight = $this->accept($flight);

        return redirect()->route('flights.show', ['flight' => $flight]);
    }

    /**
     * Generate a code.
     *
     * @param \App\Models\Flights\FlightRequest $flight
     *
     * @return \Illuminate\Http\Response
     */
    public function generateCode(FlightRequest $flight)
    {
        $flight->code = FlightRequest::generateCode();
        $flight->save();

        return redirect()->back();
    }
}
