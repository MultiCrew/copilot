<?php

namespace App\Http\Controllers\Aircraft;

use App\Http\Controllers\Controller;
use App\Models\Aircraft\ApprovedAircraft;
use App\Models\Aircraft\Aircraft;
use Illuminate\Http\Request;

class ApprovedAircraftAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
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
            'aircraft'  => $aircraft,
            'icao_acft' => Aircraft::where('icao', $aircraft->icao)->get()->first()
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
            $aircraft->icao = $request->icao;
            $aircraft->name = $request->name;
            $aircraft->sim = $request->sim;

            if ($request->action == 'approve') {
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
