<?php

namespace App\Http\Controllers\Aircraft;

use App\Http\Controllers\Controller;
use App\Models\AircraftApprovedAircraft;
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
        return view('aircraft.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ApprovedAircraft  $approvedAircraft
     * @return \Illuminate\Http\Response
     */
    public function show(ApprovedAircraft $approvedAircraft)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ApprovedAircraft  $approvedAircraft
     * @return \Illuminate\Http\Response
     */
    public function edit(ApprovedAircraft $approvedAircraft)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApprovedAircraft  $approvedAircraft
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApprovedAircraft $approvedAircraft)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApprovedAircraft  $approvedAircraft
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApprovedAircraft $approvedAircraft)
    {
        //
    }
}
