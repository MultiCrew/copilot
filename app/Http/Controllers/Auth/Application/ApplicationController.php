<?php

namespace App\Http\Controllers\Auth\Application;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Users\ApplicationForm;

class ApplicationController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:new']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('application.create');
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
            'software_dev' => 'required',
            'flight_sim' => 'required',
            'online' => 'required'
        ]);

        $application = new ApplicationForm();

        $application->user_id = Auth::user()->id;
        $application->software_dev = $request->software_dev;
        $application->flight_sim = $request->flight_sim;
        $application->network = $request->online;

        $application->status = 'pending';

        $application->save();

        return;
    }
}