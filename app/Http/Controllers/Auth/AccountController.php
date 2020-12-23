<?php

namespace App\Http\Controllers\Auth;

use Session;
use Illuminate\Http\Request;
use App\Models\Airports\Airport;
use App\Models\Aircraft\Aircraft;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\Users\UserNotification;
use \App\Http\Controllers\Controller as Controller;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user's account details in an editable form
     *
     * @return view
     */
    public function index()
    {
		$userNotifications = UserNotification::where('user_id', Auth::id())->first();
		$airports = [];
		$aircrafts = [];

		$userAirports = $userNotifications->new_request['airports'];

		if($userAirports) {
			for ($i=0; $i < count($userAirports); $i++) {
				$airport = Airport::where('icao', $userAirports[$i])->first();
				array_push($airports, $airport);
			}
		}

		$userAircrafts = $userNotifications->new_request['aircrafts'];

		if($userAircrafts) {
			for ($i=0; $i < count($userAircrafts); $i++) {
				$aircraft = Aircraft::where('icao', $userAircrafts[$i])->first();
				array_push($aircrafts, $aircraft);
			}
		}

        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $role = 'Admin';
        } else if ($user->hasRole('user')) {
            $role = 'Beta Tester';
        } else {
            $role = 'Regular User';
        }

        $clientRequest = Request::create(config('app.url') .'/oauth/clients');
        $response = Route::dispatch($clientRequest);

        $clients = json_decode($response->getContent(), true);

        $tokenRequest = Request::create(config('app.url') .'/oauth/tokens');
        $response = Route::dispatch($tokenRequest);

        $tokens = json_decode($response->getContent(), true);

        return view('auth.users.show', [
            'user' => $user,
            'role' => $role,
            'userNotifications' => $userNotifications,
			'airports' => $airports,
            'aircrafts' => $aircrafts,
            'clients' => $clients,
            'tokens' => $tokens
        ]);
    }

    /**
     * Updates the authenticated user's account details
     *
     * @param      \Illuminate\Http\Request  $request  New account details
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        return redirect()->route('account.index');
    }
}
