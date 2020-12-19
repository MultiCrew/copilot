<?php

namespace App\Http\Controllers\Discord;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Users\UserNotification;
use App\Notifications\DiscordSendData;
use Laravel\Socialite\Facades\Socialite;
use Wohali\OAuth2\Client\Provider\Discord;

class DiscordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Redirect the user to the Discord authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect()
    {
        return Socialite::driver('discord')->scopes(['guilds.join', 'identify'])->redirect();
    }

    /**
     * Obtain the user information from Discord.
     *
     * @return \Illuminate\Http\Response
     */
    public function callback()
    {
        $discordUser = Socialite::driver('discord')->user();

        $user = Auth::user();
        $user->discord_id = $discordUser->getId();
        $user->save();
        $message = $user->username . ', this is a confirmation that your MultiCrew account is now connected to Discord.';
        $roleList = $user->roles;
        $roles = array();
        for ($i = 0; $i < count($roleList); $i++) {
            $role = $roleList[$i];
            array_push($roles, $role->discord_id);
        }
        $user->notify(new DiscordSendData('connection', $message, $user, $roles));
        return redirect()->route('account.index');
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
