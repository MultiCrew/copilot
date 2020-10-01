<?php

namespace App\Http\Controllers\Discord;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Users\UserNotification;
use App\Notifications\DiscordSendData;
use Wohali\OAuth2\Client\Provider\Discord;

class DiscordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
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
			header('Location: ' . $authUrl); exit;
		
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
				$message = $user->username . ', this is a confirmation that your MultiCrew account is now connected to Discord.';
				$roleList = $user->roles;
				$roles = array();
				for ($i=0; $i < count($roleList); $i++) { 
					$role = $roleList[$i];
					array_push($roles, $role->discord_id);
				}
				$user->notify(new DiscordSendData('connection', $message, $user, $roles));
				return redirect()->route('account.index');
		
			} catch (Exception $e) {
		
				// Failed to get user details
				exit('Oh dear...');
		
			}
		}
	}

	/**
	 * Disconnect a Discord Account
	 * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
	 */
	public function disconnect(Request $request)
	{
		$user = Auth::user();
		$user->discord_id = null;
		$user->save();

		$userNotification = UserNotification::where('user_id', Auth::id())->first();
		$userNotification->request_accepted_push = 0;
		$userNotification->plan_reviewed_push = 0;
		$userNotification->save();

		return redirect()->route('account.index');
	}
}
