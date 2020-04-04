<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Models\Airports\Airport;
use App\Models\Aircraft\Aircraft;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Return all the airports in the database
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function airport(Request $request)
    {
        if ($request->ajax()) {

			$airports = Airport::where('icao', 'LIKE', '%'. $request->query('q').'%')
								->orWhere('name', 'LIKE', '%'. $request->query('q').'%')
								->get();

            return $airports;

        }
	}
	
	/**
     * Return all the aircrafts in the database
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function aircraft(Request $request)
    {
        if ($request->ajax()) {

			$aircrafts = Aircraft::where('icao', 'LIKE', '%'. $request->query('q').'%')
								->orWhere('name', 'LIKE', '%'. $request->query('q').'%')
								->get();

            return $aircrafts;

        }
    }
}
