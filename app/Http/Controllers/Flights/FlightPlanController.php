<?php

namespace App\Http\Controllers\Flights;

use App\Events\StandUpdate;
use Illuminate\Http\Request;
use App\Models\Flights\FlightRequest;
use App\Models\Flights\FlightPlan;
use App\Notifications\PlanAccepted;
use App\Notifications\PlanRejected;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FlightPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:user']);

        $this->middleware(['plan_role:member'])->except(['index', 'create', 'upload', 'store']);
        $this->middleware(['flight_role:member'])->only(['create', 'upload', 'store']);
        $this->middleware(['is_plannable'])->only(['create', 'upload']);
    }

    /**
     * Show the flight planning index page, or redirect to an appropriate stage of the
     * flight planning process, if a flight ID is specified
     *
     * @param int $id (Optional) FlightRequest plan ID
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dispatch.index', [
            'plannedFlights'    => FlightRequest::plannedFlight()->all(),
            'unplannedFlights'  => FlightRequest::unplannedFlight()->all()
        ]);
    }

    /**
     * Show the form for planning a flight, or redirect if at another stage
     *
     * @param FlightRequest flight to plan
     *
     * @return View
     */
    public function create(FlightRequest $flight)
    {
        return view('dispatch.create', ['flight' => $flight]);
    }

    /**
     * Show the form to upload an existing plan PDF
     *
     * @param FlightRequest flight to plan
     *
     * @return View
     */
    public function upload(FlightRequest $flight)
    {
        return view('dispatch.upload', ['flight' => $flight]);
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
        $flight = FlightRequest::findOrFail($request->flight);
        $plan = new FlightPlan();

        if ($request->hasFile('plan')) {
            $request->validate([
                'plan' => 'required|mimes:pdf|max:2000'
            ]);
            // save pdf with generated filename and assign filename to plan model
            $plan->file = $request->file('plan')->storeAs(
                'public/plans',
                FlightPlan::generateCode() . '.pdf'
            );
        } else {
            /**
             * SimBrief API helper file for dealing with API response
             *
             * @var $simbrief
             */
            include('simbrief/simbrief.apiv1.php');

            // store ofp json data
            $plan->ofp_json = $simbrief->ofp_json;
        }
        $plan->save();

        // associate plan to flight
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

        if (!empty($plan->ofp_json)) {
            return view('dispatch.show', [
                'plan'      => $plan,
                'flight'    => $plan->flight,
                'fpl'       => json_decode($plan->ofp_json, true)
            ]);
        } else {
            return view('dispatch.show-pdf', [
                'plan'      => $plan,
                'flight'    => $plan->flight,
            ]);
        }
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

    /**
     * Assign a stand to the departure or arrival airport
     *
     * @param FlightPlan $plan
     * @param Request $request
     */
    public function stand(FlightPlan $plan, Request $request)
    {
        switch ($request->type) {
            case 'dep_stand':
                $plan->dep_stand = $request->number;
                break;
            case 'arr_stand':
                $plan->arr_stand = $request->number;
                break;
        }
        event(new StandUpdate($request->number, $request->type));
        $plan->save();
    }
}
