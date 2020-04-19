<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Flights\Flight;
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
        
        /** @var string $id */
        $id = $request->route('id');

        /** @var string $code */
        $code = $request->route('code');

        switch($role){
            case 'participant':
                if(!$flight->isRequestee(Auth::user()) && !$flight->isAcceptee(Auth::user())) abort(403);
                break;
            case 'requestee':
                if(!$flight->isRequestee(Auth::user())) abort(403);
                break;
            case 'privateGuest':
                $flight = Flight::where('code', $code)->first();
                if($flight->isRequestee(Auth::user()) || $flight->isAcceptee(Auth::user())) abort(403);
                break;
            case 'publicGuest':
                $flight = Flight::find($id);
                if($flight->isRequestee(Auth::user()) || $flight->isAcceptee(Auth::user())) abort(403);
                break;
        }
        return $next($request);
    }
}
