<?php

namespace App\Http\Controllers\Aircraft;

use App\Http\Controllers\Controller;
use App\Models\Aircraft\ApprovedAircraft;
use App\Models\FlightSim\Simulator;
use Illuminate\Http\Request;
use App\Models\Aircraft\Aircraft;
use Auth;

class ApprovedAircraftController extends Controller
{
    public function __construct()
    {
        $this->middleware(['fleet'])->except(['index', 'store']);
    }

    /**
     * Resource index
     */
    public function index()
    {
        return view('aircraft.index', [
            'aircrafts' => ApprovedAircraft::orderBy('approved', 'asc')->orderBy('icao', 'asc')->get(),
            'simulators' => Simulator::all(),
        ]);
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
            'icao' => 'required|exists:aircraft,icao',
            'name' => 'required|max:100',
            'sim' => 'required|max:50'
        ]);

        $aircraft = ApprovedAircraft::create([
            'icao' => $request->icao,
            'name' => $request->name,
            'sim'  => $request->sim,
            'added_by' => Auth::user()->username,
            'approved' => false
        ]);

        return redirect()->route('aircraft.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  ApprovedAircraft $aircraft
     * @return \Illuminate\Http\Response
     */
    public function show(ApprovedAircraft $aircraft)
    {
        return view('aircraft.show', [
            'aircraft'      => $aircraft,
            'simulators'    => Simulator::all(),
            'icao_acft'     => Aircraft::where('icao', $aircraft->icao)->get()->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ApprovedAircraft $aircraft
     * @return \Illuminate\Http\Response
     */
    public function update(ApprovedAircraft $aircraft, Request $request)
    {
        $request->validate([
            'icao' => 'required|exists:aircraft,icao',
            'name' => 'required|max:100',
            'sim' => 'required|max:50'
        ]);

        $aircraft->icao = $request->icao;
        $aircraft->name = $request->name;
        $aircraft->sim = $request->sim;

        if ($request->action == 'approve' && Auth::user()->hasRole('admin')) {
            $aircraft->approved = true;
        }

        $aircraft->save();

        return redirect()->route('aircraft.show', $aircraft);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ApprovedAircraft $aircraft
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApprovedAircraft $aircraft)
    {
        $aircraft->delete();
        return redirect()->route('aircraft.index');
    }
}
