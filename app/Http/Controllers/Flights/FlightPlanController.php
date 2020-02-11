<?php

namespace App\Http\Controllers\Flights;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flights\Flight;
use App\Models\Flights\FlightPlan;
use App\Notifications\PlanAccepted;
use App\Notifications\PlanRejected;
use \Auth;

class FlightPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(['plan_role:member'])->except('index', 'create', 'store');
        $this->middleware(['flight_role:member'])->only('create', 'store');
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
            return redirect()->route('dispatch.show', $flight->plan_id);
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

        $flight->plan()->associate($plan);
        $flight->save();

        return redirect()->route('dispatch.show', ['plan' => $plan]);
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

        return view('dispatch.show', [
            'plan'      => $plan,
            'flight'    => $plan->flight,
            'fpl'       => json_decode($plan->ofp_json, true)
        ]);
    }

    /**
     * Destroys the resource instance
     *
     * @param $plan FlightPlan object instance to remove
     */
    public function destroy(FlightPlan $plan)
    {
        $flight = $plan->flight;
        $flight->plan()->dissociate();
        $flight->save();

        $plan->delete();
        return;
    }

    /**
     * Method to accept a flight plan as the authed user
     *
     * @param FlightPlan to accept
     * @return Redirect to flight plan
     */
    public function accept(FlightPlan $plan)
    {
        $plan->accept();
        $plan->flight->otherUser()->notify(new PlanAccepted(Auth::user(), $plan->flight));
        return redirect()->route('dispatch.show', [$plan]);
    }

    /**
     * Method to reject a flight plan as the authed user
     *
     * @param FlightPlan to reject
     * @return Redirect to flight plan
     */
    public function reject(FlightPlan $plan)
    {
        $flight = $plan->flight;
        $this->destroy($plan);

        $plan->flight->otherUser()->notify(new PlanRejected(Auth::user(), $plan->flight));
        return redirect()->route('dispatch.create', [$flight]);
    }
}
