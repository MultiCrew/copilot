<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Users\Profile;
use App\Models\FlightSim\Simulator;
use App\Models\FlightSim\WeatherEngine;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['profile'])->except('show');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        // correct null values for empty array
        if ($profile->sims === null) {
            $profile->sims = [0];
        }
        if ($profile->weather === null) {
            $profile->weather = [0];
        }

        return view('auth.profiles.show', [
            'profile'   => $profile,
            'sims'      => Simulator::all(),
            'wxs'       => WeatherEngine::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Profile             $profile
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        if (isset($request->showName)) {
            $profile->show_name = $request->showName;
            $profile->location = $request->location;
        } else {
            $profile->fill([
                'sims'          => $request->sims,
                'weather'       => $request->weather,
                'airac'         => $request->airac,
                'level'         => $request->level,
                'connection'    => $request->connection,
                'procedures'    => $request->procedures
            ]);
        }
        $profile->save();

        return redirect()->route('profile.show', $profile);
    }

    /**
     * Update the user's profile picture
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Profile             $profile
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePicture(Request $request, Profile $profile)
    {
        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        Storage::delete($profile->picture);

        $profile->picture = $request->file('picture')->store('public/profile');
        $profile->save();

        return redirect()->route('profile.show', $profile);
    }

    /**
     * Remove the user's profile picture
     *
     * @param  \App\Profile             $profile
     *
     * @return \Illuminate\Http\Response
     */
    public function removePicture(Profile $profile)
    {
        Storage::delete($profile->picture);

        $profile->picture = null;
        $profile->save();

        return redirect()->route('profile.show', $profile);
    }
}
