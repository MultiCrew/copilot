<?php

namespace App\Http\Controllers\Flights;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flights\Flight;
use App\Models\Flights\FlightPlan;
use \Auth;

class FlightPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(['flight_role:guest'])->only(['store']);
    }

    /**
     * Show the flight planning index page, or redirect to an appropriate stage of the
     * flight planning process, if a flight ID is specified
     *
     * @param int $id (Optional) Flight plan ID
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dispatch.index', [
            'plannedFlights'    => Flight::plannedFlight()->all(),
            'unplannedFlights'  => Flight::unplannedFlight()->all()
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

        return view('dispatch.create', ['flight' => $flight]);
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
        // helpful debugging line to view contents of plan JSON
        // dd(json_decode($plan->ofp_json, true));
        if ($plan->acceptee_accept == 0 && $plan->requestee_accept == 0) {
            $review = true;
        } else {
            $review = false;
        }
        return view('dispatch.show', [
            'flight'    => Flight::where('plan_id', $plan->id)->first(),
            'plan'      => $plan,
            'review'    => $review,
            'fpl'       => json_decode($plan->ofp_json, true)
        ]);
    }
}
