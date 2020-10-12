<?php

namespace App\Http\Controllers\API\Discord;

use Exception;
use GuzzleHttp\Client;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Flights\FlightRequest;
use App\Notifications\RequestAccepted;
use App\Models\Aircraft\ApprovedAircraft;
use App\Http\Resources\Flights\RequestResource;

class FlightController extends Controller
{
    /**
     * Search the database for flights, based on a query parameter if given in the request
     * Method can be called either in ajax or PHP, see below
     *
     * @param      \Illuminate\Http\Request     $request
     * @return     JSON Array | PHP array       Array of flights found based on request
     */
    public function search(Request $request)
    {
        $query = '';
        if ($request->path() == 'api/search' && $request->get('query')) {
            $query = $request->get('query');
        }
        if ($query != '') {
            $aircraft = preg_grep('/^[A-Z]{1,}[0-9]{1,}[A-Z]?$/i', $query);

            $aircraftArray = ApprovedAircraft::where('approved', 1)->whereIn('icao', $aircraft)->pluck('id')->all();

            $data = FlightRequest::where('public', 1)
                ->where(function ($q) use ($query) {
                    foreach ($query as $apt) {
                        $q->whereJsonContains('departure', $apt);
                        $q->orWhereJsonContains('arrival', $apt);
                    }
                })
                ->orWhereIn('aircraft_id', $aircraftArray)
                ->whereNull('acceptee_id')
                ->orderBy('id', 'asc')
                ->get()
                ->load('aircraft', 'requestee');
        } else {
            $data =
                FlightRequest::get()
                ->where('public', 1)
                ->whereNull('acceptee_id')
                ->sortBy('id')
                ->load('aircraft', 'requestee');
        }
        if ($request->ajax())
            return json_encode($data);
        else
            return $data;
    }

    /**
     * Returns a list of all approved aircraft
     * 
     * @param      \Illuminate\Http\Request     $request
     * @return     JSON Array                   Array of approved aircraft
     */
    public function aircraft(Request $request)
    {
        $aircraftArray = ApprovedAircraft::where('approved', true)->get();

        if ($request->ajax())
            return json_encode($aircraftArray);
        else
            return $aircraftArray;
    }

    /**
     * Create a new flight
     *
     * @param      \Illuminate\Http\Request     $request
     * @return     JSON Array | PHP array       Array of flights found based on request
     */
    public function store(Request $request)
    {
        $user = User::whereNotNull('discord_id')->where('discord_id', $request->requestee_id)->first();
        if (!$user) {
            return response()->json([
                'code' => '401',
                'message' => 'You have not linked your Discord account with Copilot, please visit ' . config('app.url') . '/account to link your accounts.'
            ]);
        }

        $flight = new FlightRequest();
        $aircraft = ApprovedAircraft::find($request->aircraft);
        if (!$aircraft) {
            return response()->json([
                'code' => '400',
                'message' => 'The ID of the aircraft you have selected is not valid, please try again'
            ]);
        };

        $flight->fill([
            'departure' => $request->departure,
            'arrival'   => $request->arrival,
            'aircraft_id'  => $request->aircraft
        ]);
        $flight->requestee_id = $user->id;
        $flight->public = true;
        $flight->save();

        $flight = $flight->fresh();
        return response()->json([
            'code' => '200',
            'message' => $flight
        ]);
    }

    /**
     * Accept a request
     * 
     * @param      \Illuminate\Http\Request     $request
     * @return     JSON Array | PHP array       The accepted request
     */
    public function accept(Request $request)
    {
        $user = User::whereNotNull('discord_id')->where('discord_id', $request->discord_id)->first();
        if (!$user) {
            return response()->json([
                'code' => '401',
                'message' => 'You have not linked your Discord account with Copilot, please visit ' . config('app.url') . '/account to link your accounts.'
            ]);
        }

        $flight = FlightRequest::find($request->id)->load('requestee', 'aircraft');
        if (!$flight) {
            return response()->json([
                'code' => '400',
                'message' => 'Your requested flight request does not exist.'
            ]);
        } elseif ($flight->acceptee_id) {
            return response()->json([
                'code' => '400',
                'message' => 'Your chosen flight has already been accepted by a different user'
            ]);
        } else {
            $flight->acceptee_id = $user->id;
            $flight->save();

            $requestee = $flight->requestee;
            $requestee->notify(new RequestAccepted($user, $requestee, $flight));

            try {
                if ($flight->callback) {
                    $client = new Client();
                    $client->post($flight->callback, [
                        'headers' => [
                            'Content-Type' => 'application/json'
                        ],
                        'body' => new RequestResource($flight),
                    ]);
                }
            } catch (Exception $e) {
                Log::error('Attempted to send request to callback url', [
                    'url' => $flight->callback,
                    'message' => $e->getMessage(),
                    'error' => $e
                ]);
            }

            return response()->json([
                'code' => '200',
                'message' => $flight
            ]);
        }
    }
}
