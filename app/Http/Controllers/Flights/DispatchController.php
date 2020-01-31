<?php

namespace App\Http\Controllers\Flights;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flights\Flight;

class DispatchController extends Controller
{
    /**
     * Show the flight planning index page, or redirect to an appropriate stage of the
     * flight planning process, if a flight ID is specified
     *
     * @param       int     $id (optional)    Flight ID, if redirect logic required
     *
     * @return      \Illuminate\Http\Response
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

        return view('dispatch.index');
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
}
