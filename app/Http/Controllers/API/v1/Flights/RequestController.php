<?php

namespace App\Http\Controllers\API\v1\Flights;

use Exception;
use Illuminate\Http\Request;
use App\Models\Flights\FlightRequest;
use App\Models\Aircraft\ApprovedAircraft;
use App\Http\Controllers\API\APIController as Controller;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = $request->all();
            if ($query) {
                $aircraft = preg_grep('/^[A-Z]{1,}[0-9]{1,}[A-Z]?$/i', $query['aircraft']);
                $aircraftArray = ApprovedAircraft::where('approved', 1)->whereIn('icao', $aircraft)->pluck('id')->all();

                $data = FlightRequest::with('aircraft:id,icao,name,sim', 'requestee:id,username')
                    ->where('public', 1)
                    ->where(function ($q) use ($request) {
                        foreach ($request as $apt) {
                            $q->whereJsonContains('departure', $apt);
                            $q->orWhereJsonContains('arrival', $apt);
                        }
                    })
                    ->orWhereIn('aircraft_id', $aircraftArray)
                    ->whereNull('acceptee_id')
                    ->orderBy('id', 'asc')
                    ->get();
            } else {
                $data =
                    FlightRequest::with('aircraft:id,icao,name,sim', 'requestee:id,username')
                    ->where('public', 1)
                    ->whereNull('acceptee_id')
                    ->orderBy('id')
                    ->get();
            }

            return $this->respondWithObject($data);

        } catch (Exception $e) {
            return $this->errorInternalError($e->getMessage());
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
