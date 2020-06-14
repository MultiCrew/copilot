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
            'aircrafts' => ApprovedAircraft::orderBy('icao', 'asc')->paginate(10)
        ]);
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
}
