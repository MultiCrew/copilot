<?php

namespace App\Http\Controllers\Discord;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\DiscordSendData;
use Wohali\OAuth2\Client\Provider\Discord;

class DiscordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
	}
	
	/**
     * Connect a Discord account.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function connect(Request $request) {
		$provider = new Discord([
			'clientId' => config('app.discord_id'),
    		'clientSecret' => config('app.discord_secret'),
    		'redirectUri' => config('app.discord_redirect')
		]);
		$options = [
			'scope' => 'identify'
		];
		if (!isset($_GET['code'])) {
			// Get authorization code
			$authUrl = $provider->getAuthorizationUrl($options);
			header('Location: ' . $authUrl);
		
		} else {
		
			//  Get an access token using the provided authorization code
			$token = $provider->getAccessToken('authorization_code', [
				'code' => $_GET['code']
			]);
		
			// Get id and save it to the database
			try {
		
				$discordUser = $provider->getResourceOwner($token);
				$user = Auth::user();
				$user->discord_id = $discordUser->getId();
				$user->save();
				//$user->notify(new DiscordSendData($message)); uncomment once message variable is set
				return redirect()->route('home.home');
		
			} catch (Exception $e) {
		
				// Failed to get user details
				exit('Oh dear...');
		
			}
		}
	}
}