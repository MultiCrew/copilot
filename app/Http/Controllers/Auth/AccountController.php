<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\Airports\Airport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
		
		$userAirports = $userNotifications->new_request['airports'];
		$airports = [];
		for ($i=0; $i < count($userAirports); $i++) { 
			$airport = Airport::where('icao', $userAirports[$i])->first();
			array_push($airports, $airport);
		}

        return view('auth.account', [
			'userNotifications' => $userNotifications,
			'airports' => $airports
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
