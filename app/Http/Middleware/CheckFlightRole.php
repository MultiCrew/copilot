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
        /** @var \App\Models\Flights\Flight $flight */
        $flight = $request->route('flight');

        switch($role){
            case 'requestee':
                if(!$flight->isRequestee(Auth::user())) abort(403);
                break;
            case 'acceptee':
                if(!$flight->isAcceptee(Auth::user())) abort(403);
                break;
            case 'guest':
                if(!$flight->isRequestee(Auth::user()) || !$flight->isAcceptee(Auth::user())) abort(403);
                break;
        }
        return $next($request);
    }
}
