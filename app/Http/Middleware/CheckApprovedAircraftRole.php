<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckApprovedAircraftRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $aircraft = $request->route('aircraft');

        // User must have admin role or be the creator of the aircraft to interact
        if (!($aircraft->added_by === Auth::user()->username || Auth::user()->hasRole('admin'))) {
            return redirect()->route('aircraft.index');
        }

        return $next($request);
    }
}
