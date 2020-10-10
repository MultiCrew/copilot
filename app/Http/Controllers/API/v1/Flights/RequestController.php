<?php

namespace App\Http\Controllers\API\v1\Flights;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Flights\FlightRequest;
use App\Models\Aircraft\ApprovedAircraft;
use Illuminate\Validation\ValidationException;
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
                try {
                    $request->validate([
                        'aircraft' => 'array|exists:approved_aircraft,icao',
                        'airport' => 'array|exists:airports,icao'
                    ]);
                } catch (ValidationException $e) {
                    return $this->errorWrongArgs($e->errors());
                }

                $aircraftArray = ApprovedAircraft::where('approved', 1)->whereIn('icao', $query['aircraft'])->pluck('id')->all();

                $data = FlightRequest::with('aircraft:id,icao,name,sim', 'requestee:id,username')
                    ->where('public', 1)
                    ->where(function ($q) use ($query) {
                        foreach ($query['airport'] as $apt) {
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
            return $this->errorInternalError(array($e->getMessage()));
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
