<?php

namespace App\Http\Middleware;

use Closure;

class CheckPlannableFlight
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
        $flight = $request->route('flight');

        if ($flight->isPlanned()) {
            return redirect()->route('dispatch.show', $flight->plan_id);
        } elseif (!$flight->isAccepted() || !$flight->isDispatchable()) {
            return redirect()->route('flights.show', $flight);
        }

        return $next($request);
    }
}
