<?php

namespace App\Http\Controllers\API\v1\Flights;

use Exception;
use Lcobucci\JWT\Parser;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use App\Http\Traits\WebhookTrait;
use App\Notifications\NewRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Flights\FlightRequest;
use App\Models\Flights\ArchivedFlight;
use App\Models\Users\UserNotification;
use App\Notifications\RequestAccepted;
use App\Models\Aircraft\ApprovedAircraft;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Flights\RequestResource;
use App\Http\Requests\StoreFlightRequestRequest;
use App\Http\Requests\UpdateFlightRequestRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\API\APIController as Controller;

/**
 * @group Flight Requests
 *
 * Endpoints for managing flight requests
 */
class RequestController extends Controller
{
    use WebhookTrait;

    /**
     * Search Requests
     *
     * Search for all flight requests or narrow down the search using the optional paramaters
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @queryParam aircraft string[] An array of aircraft ICAO codes. Example: ["A318"]
     * @queryParam airport string[] An array of airport ICAO codes. Example: ["EGKK", "EHAM"]
     *
     * @responseFile responses/request.index.json
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
     * Create a Request
     *
     * Create a new public or private Flight Request.
     *
     * Include the optional `callback` parameter to get notified when the request is accepted.
     *
     * Note: Either `departure` or `arrival` must have at least 1 ICAO code for the request to be stored.
     *
     * *Requires `request.create` scope*
     *
     * @responseFile responses/request.json
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFlightRequestRequest $request)
    {
        if ($request->user()->tokenCan('request.create')) {
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

                if ($request->callback) {
                    $flightRequest->callback = $request->callback;

                    try {
                        $bearerToken = request()->bearerToken();
                        $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
                        $client = Token::find($tokenId)->client;
                    } catch (Exception $e) {
                        Log::error($e);
                    }
                    $flightRequest->client_id = $client->id;
                }

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
        } else {
            return $this->errorUnauthorized(['INVALID_SCOPE']);
        }
    }

    /**
     * Get a specific Request
     *
     * @urlParam request integer required The ID of the Request
     * @responseFile responses/request.json
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
            return $this->respondWithObject(new RequestResource($request));
        } else if (!$request->public && ($request->acceptee_id != Auth::id() || $request->requestee_id != Auth::id())) {
            return $this->errorUnauthorized();
        } else {
            return $this->respondWithObject(new RequestResource($request));
        }
    }

    /**
     * Update a Request
     *
     * Update a public or private Flight Request.

     * Include the optional callback parameter to get notified when the request is accepted.

     * Note: Either departure or arrival must have at least 1 ICAO code for the request to be stored.
     *
     * *Requires `request.manage` scope*
     *
     * @urlParam request integer required The ID of the Request
     * @responseFile responses/request.json
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFlightRequestRequest $request, $id)
    {
        if (Auth::user()->tokenCan('request.manage')) {
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
                if ($request->callback) {
                    $flightRequest->callback = $request->callback;

                    try {
                        $bearerToken = request()->bearerToken();
                        $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
                        $client = Token::find($tokenId)->client;
                    } catch (Exception $e) {
                        Log::error($e);
                    }
                    $flightRequest->client_id = $client->id;
                }

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
        } else {
            return $this->errorUnauthorized(['INVALID_SCOPE']);
        }
    }

    /**
     * Remove a Request
     *
     * *Requires `request.manage` scope*
     *
     * @urlParam request integer required The ID of the Request
     * @response {
     *      "message": "Resource deleted"
     * }
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->tokenCan('request.manage')) {
            try {
                $flightRequest = FlightRequest::findOrFail($id);
            } catch (ModelNotFoundException $e) {
                return $this->errorNotFound(array($e->getMessage()));
            }
            if ($flightRequest->requestee_id == Auth::id()) {
                try {
                    $flightRequest->delete();
                    return $this->respondWithMessage('Resource deleted');
                } catch (Exception $e) {
                    return $this->errorInternalError(array($e->getMessage()));
                }
            } else {
                return $this->errorUnauthorized();
            }
        } else {
            return $this->errorUnauthorized(['INVALID_SCOPE']);
        }
    }

    /**
     * Accept a Request
     *
     * Accept a public or private Request.
     *
     * Note: To accept a private Request, a valid `code` must be passed with the request.
     *
     * *Requires `request.manage` scope*
     *
     * @urlParam request integer required The ID of the Request
     * @urlParam code string The code required to accept a private Request
     * @responseFile responses/request.json
     *
     * @param int $id
     * @param string $code
     * @return \Illuminate\Http\Response
     */
    public function accept($id, $code = null)
    {
        if (Auth::user()->tokenCan('request.manage')) {
            try {
                if (!$code) {
                    $flightRequest = FlightRequest::where('id', $id)->whereNull('code')->firstOrFail();
                } else {
                    $flightRequest = FlightRequest::where('id', $id)->where('code', $code)->firstOrFail();
                }
            } catch (ModelNotFoundException $e) {
                return $this->errorNotFound(array($e->getMessage()));
            }

            try {
                if ($flightRequest->isRequestee(Auth::user()) || $flightRequest->isAcceptee(Auth::user())) {
                    return $this->respondWithError('The authenticated user is already a participant of this request', [], 400);
                } else {
                    $flightRequest->acceptee_id = Auth::id();
                    $flightRequest->save();

                    $requestee = $flightRequest->requestee;
                    $requestee->notify(new RequestAccepted(Auth::user(), $requestee, $flightRequest));

                    if ($flightRequest->callback) {
                        $this->requestCall($flightRequest, 'Accepted');
                    }

                    return $this->respondWithObject(new RequestResource($flightRequest));
                }
            } catch (Exception $e) {
                return $this->errorInternalError(array($e->getMessage()));
            }
        } else {
            return $this->errorUnauthorized(['INVALID_SCOPE']);
        }
    }

    /**
     * @group User
     *
     * Get all the User's Requests
     *
     * Returns 3 arrays containing the User's `open` (unaccepted), `accepted` and `archived` Requests
     *
     * @responseFile responses/UserRequest.json
     *
     * @param Request $request
     * @return void
     */
    public function userRequests(Request $request)
    {
        if ($request->user()->tokenCan('request.manage')) {
            try {
                try {
                    $openRequests = FlightRequest::whereNull('acceptee_id')
                    ->where('requestee_id', '=', $request->user()->id)
                    ->get();
                } catch (ModelNotFoundException $e) {
                    return $this->errorNotFound(array($e->getMessage()));
                }

                try {
                    $acceptedRequests = FlightRequest::whereNotNull('acceptee_id')
                    ->where(function ($query) use ($request)  {
                        $query->where('requestee_id', '=', $request->user()->id)
                            ->orWhere('acceptee_id', '=', $request->user()->id);
                    })->get();
                } catch (ModelNotFoundException $e) {
                    return $this->errorNotFound(array($e->getMessage()));
                }

                try {
                    $archivedFlights = ArchivedFlight::where('requestee_id', '=', $request->user()->id)
                    ->orWhere('acceptee_id', '=', $request->user()->id)
                    ->get();
                } catch (ModelNotFoundException $e) {
                    return $this->errorNotFound(array($e->getMessage()));
                }

                $responseObject = (object)[
                    'open' => RequestResource::collection($openRequests),
                    'accepted' => RequestResource::collection($acceptedRequests),
                    'archived' => RequestResource::collection($archivedFlights),
                ];

                return $this->respondWithObject($responseObject);
            } catch (Exception $e) {
                return $this->errorInternalError(array($e->getMessage()));
            }
        } else {
            return $this->errorUnauthorized(['INVALID_SCOPE']);
        }
    }
}
