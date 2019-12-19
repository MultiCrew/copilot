<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckFlightRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string $role
     * @return mixed
     */
    public function handle($request, Closure $next, string $role)
    {
        /** @var \App\Models\Flights\FlightRequest $flight */
        $flight = $request->route('flight');

        switch($role){
            case 'participant':
                //if(!$flight->isParticipant(Auth::user())) abort(403);
                break;
            case 'organiser':
                //if(!$flight->isOrganiser(Auth::user())) abort(403);
                break;
        }
        return $next($request);
    }
}
