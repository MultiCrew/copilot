<?php

namespace App\Http\Controllers\API\v1\Flights;

use App\Http\Controllers\API\APIController as Controller;
use App\Http\Requests\StoreFlightRequestRequest;
use App\Http\Requests\UpdateFlightRequestRequest;
use App\Http\Resources\Flights\RequestResource;
use App\Models\Aircraft\ApprovedAircraft;
use App\Models\Flights\FlightRequest;
use App\Models\Users\UserNotification;
use App\Notifications\NewRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

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
                        'airport' => 'array|exists:airports,icao',
                    ]);
                } catch (ValidationException $e) {
                    return $this->errorWrongArgs($e->errors());
                }

                $aircraftArray = ApprovedAircraft::where('approved', 1)->whereIn('icao', $query['aircraft'])->pluck('id')->all();

                $data =
                RequestResource::collection(FlightRequest::where('public', 1)
                        ->whereNull('acceptee_id')
                        ->where(function ($q) use ($query) {
                            foreach ($query['airport'] as $apt) {
                                $q->whereJsonContains('departure', $apt);
                                $q->orWhereJsonContains('arrival', $apt);
                            }
                        })
                        ->orWhereIn('aircraft_id', $aircraftArray)
                        ->orderBy('id')
                        ->get());
            } else {
                $data =
                RequestResource::collection(FlightRequest::where('public', 1)
                        ->whereNull('acceptee_id')
                        ->orderBy('id')
                        ->get());
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
    public function store(StoreFlightRequestRequest $request)
    {
        try {
            $aircraft = ApprovedAircraft::where('icao', $request->aircraft)->pluck('id')->first();

            $flightRequest = new FlightRequest();
            $flightRequest->fill([
                'departure' => $request->departure,
                'arrival' => $request->arrival,
                'aircraft_id' => $aircraft,
                'requestee_id' => Auth::id(),
                'public' => $request->public,
            ]);
            if (!$request->public) {
                $flightRequest->code = FlightRequest::generateCode();
            }
            $flightRequest->save();

            $users = UserNotification::whereJsonContains('new_request->airports', $request->departure)
                ->orWhereJsonContains('new_request->airports', $request->arrival)
                ->orWhereJsonContains('new_request->aircrafts', $aircraft)
                ->where('user_id', '!=', Auth::id())
                ->with('user')
                ->get()
                ->pluck('user')
                ->flatten();
            Notification::send($users, new NewRequest(Auth::user(), $flightRequest));
            $flightRequest->fresh();

            return $this->respondWithObject(new RequestResource($flightRequest));
        } catch (Exception $e) {
            return $this->errorInternalError(array($e->getMessage()));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $request = FlightRequest::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->errorNotFound(array($e->getMessage()));
        }
        if (!$request->public && ($request->acceptee_id == Auth::id() || $request->requestee_id == Auth::id())) {
            return new RequestResource($request);
        } else if (!$request->public && ($request->acceptee_id != Auth::id() || $request->requestee_id != Auth::id())) {
            return $this->errorUnauthorized();
        } else {
            return new RequestResource($request);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFlightRequestRequest $request, $id)
    {
        try {
            $flightRequest = FlightRequest::findOrFail($id);
            $aircraft = ApprovedAircraft::where('icao', $request->aircraft)->pluck('id')->first();

            $flightRequest->fill([
                'departure' => $request->departure,
                'arrival' => $request->arrival,
                'aircraft_id' => $aircraft,
                'requestee_id' => Auth::id(),
                'public' => $request->public,
            ]);
            if (!$request->public) {
                $flightRequest->code = FlightRequest::generateCode();
            }
            if ($request->public && $flightRequest->code) {
                $flightRequest->code = null;
            }
            $flightRequest->save();
            $flightRequest->fresh();

            return $this->respondWithObject(new RequestResource($flightRequest));
        } catch (Exception $e) {
            return $this->errorInternalError(array($e->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $request = FlightRequest::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->errorNotFound(array($e->getMessage()));
        }
        if ($request->requestee_id == Auth::id()) {
            try {
                $request->delete();
                return $this->respondWithMessage('Resource deleted');
            } catch (Exception $e) {
                return $this->errorInternalError(array($e->getMessage()));
            }
        } else {
            return $this->errorUnauthorized();
        }
    }
}
