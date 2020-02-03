<?php

namespace App\Http\Controllers\Flights;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flights\Flight;
use App\Models\Flights\FlightPlan;
use \Auth;

class DispatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the flight planning index page, or redirect to an appropriate stage of the
     * flight planning process, if a flight ID is specified
     *
     * @param int $id (Optional) Flight plan ID
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        if (!empty($id)) {
            if ($flight = Flight::find($id)) {
                if (!$flight->plan_id) {
                    return redirect()->route('dispatch.plan', $flight->id);
                }
            }
        }

        // no Flight specified, show the index of the planning page
        $plannedFlights =   Flight::whereNotNull('acceptee_id')
                            ->where(function($query) {
                                $query->where('requestee_id', '=', Auth::user()->id)
                                      ->orWhere('acceptee_id', '=', Auth::user()->id);
                            })->whereNotNull('plan_id')->get();
        $unplannedFlights = Flight::whereNotNull('acceptee_id')
                            ->where(function($query) {
                                $query->where('requestee_id', '=', Auth::user()->id)
                                      ->orWhere('acceptee_id', '=', Auth::user()->id);
                            })->whereNull('plan_id')->get();

        return view('flights.dispatch.index', [
            'plannedFlights' => $plannedFlights,
            'unplannedFlights' => $unplannedFlights
        ]);
    }

    /**
     * Show the form for planning a flight, or redirect if at another stage
     *
     * @param int $id Flight ID
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $flight = Flight::findOrFail($id);

        if ($flight->plan_id) {
            return redirect()->route('dispatch.review', $flight->plan_id);
        }

        return view('flights.dispatch.plan', ['flight' => $flight]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request Form data
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $flight = Flight::findOrFail($request->flight);

        /**
         * @var $simbrief
         */
        include('simbrief/simbrief.apiv1.php');

        /**
         * Perform some checks to ensure this plan is valid
         */
        if ($flight->requestee_id !== Auth::id() || $flight->acceptee_id !== Auth::id()) {
            // user not authorised to plan flight
        }

        if (!empty($flight->plan_id)) {
            // flight already has a plan of some sort (accepted or in review)
        }

        $plan = new FlightPlan();
        $plan->ofp_json = $simbrief->ofp_json;
        $plan->save();

        $flight->plan_id = $plan->id;
        $flight->save();

        return redirect()->route('dispatch.review', ['plan' => $plan]);
    }

    /**
     * Displays the flight plan for the given ID
     *
     * @param \App\Models\Flights\FlightPlan $flight The flight
     */
    public function show(FlightPlan $plan)
    {
        return view('flights.dispatch.show', [
            'plan' => $plan,
            'fpl' => json_decode($plan->ofp_json, true)
        ]);
    }
}
