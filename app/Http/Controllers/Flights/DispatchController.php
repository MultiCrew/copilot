<?php

namespace App\Http\Controllers\Flights;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flights\Flight;
use \Auth;

class DispatchController extends Controller
{
    /**
     * Show the flight planning index page, or redirect to an appropriate stage of the
     * flight planning process, if a flight ID is specified
     *
     * @param      int    $id     The identifier
     *
     * @return     \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        if (!empty($id))
        {
            if ($flight = Flight::find($id))
            {
                if (!$flight->plan_id)
                    return redirect()->route('dispatch.plan', $flight->id);
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
                            })->whereNull('plan_id')->get();;

        return view('flights.dispatch.index', [
            'plannedFlights' => $plannedFlights,
            'unplannedFlights' => $unplannedFlights
        ]);
    }

    /**
     * Show the form for planning a flight, or redirect if at another stage
     *
     * @param      int    $id     The identifier
     *
     * @return     \Illuminate\Http\Response
     */
    public function create($id)
    {
        $flight = Flight::findOrFail($id);

        if ($flight->plan_id)
            return redirect()->route('dispatch.review', $flight->plan_id);

        return view('flights.dispatch.plan', ['flight' => $flight]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * @var $simbrief
         */
        include('simbrief/simbrief.apiv1.php');

        $data = $simbrief->ofp_array;
        dd($data);

        // $plan = new FlightPlan();
        // $plan->fill($data, $simbrief->ofp_json);

        // $data = $simbrief->ofp_array;
        // $participant = $flight->userParticipant(Auth::user());
        // $participant->flight_plan_url = $data['files']['directory'] . $data['files']['pdf']['link'];

        // if ($flight->isOrganiser(Auth::user()) && $flight->route == null)
        //     $flight->route = $data['atc']['route'];

        // if ($flight->isOrganiser(Auth::user()) && $flight->ete == null)
        //     $flight->ete = gmdate("H:i", $data['times']['est_time_enroute']);

        // if ($flight->isOrganiser(Auth::user()))
        // {
        //     $routeData = array(); $i = 0;
        //     foreach($data['navlog']['fix'] as $fix)
        //     {
        //         $routeData[$i]['ident'] = $fix['ident'];
        //         $routeData[$i]['lat'] = $fix['pos_lat'];
        //         $routeData[$i]['long'] = $fix['pos_long'];
        //         $i++;
        //     }
        //     $flight->simbrief_route_data = json_encode($routeData);
        // }

        // $flight->save();
        // $participant->save();

        // return redirect()->route('flights.view', ['flight' => $flight]);
    }

    /**
     * { function_description }
     *
     * @param      \App\Models\Flights\Flight  $flight  The flight
     */
    public function show(Flight $flight)
    {

    }
}
