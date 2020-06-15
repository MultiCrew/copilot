<?php

namespace App\Http\Controllers\Aircraft;

use App\Http\Controllers\Controller;
use App\Models\Aircraft\ApprovedAircraft;
use Illuminate\Http\Request;

class ApprovedAircraftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('aircraft.index', [
            'aircrafts' => ApprovedAircraft::orderBy('approved', 'asc')->orderBy('icao', 'asc')->paginate(10)
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
        $aircraft = ApprovedAircraft::create([
            'icao' => $request->icao,
            'name' => $request->name,
            'sim'  => $request->sim,
            'added_by' => \Auth::user()->username,
            'approved' => false
        ]);

        return redirect()->route('aircraft.index');
    }
}
