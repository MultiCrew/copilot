<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Flights\FlightPlan;
use Illuminate\Support\Facades\Auth;

class CheckPlanRole
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
        /** @var \App\Models\Flights\FlightPlan $plan */
        $plan = $request->route('plan');
        
        /** @var string $id */
        $id = $request->route('id');

        switch($role){
            case 'requestee':
                if(!$plan->flight->isRequestee(Auth::user())) abort(403);
                break;
            case 'acceptee':
                if(!$plan->flight->isAcceptee(Auth::user())) abort(403);
                break;
            case 'member':
                if(!$plan->flight->isRequestee(Auth::user()) && !$plan->flight->isAcceptee(Auth::user())) abort(403);
                break;
            case 'guest':
                $plan = Plan::find($id);
                if($plan->flight->isRequestee(Auth::user()) || $plan->flight->isAcceptee(Auth::user())) abort(403);
                break;
        }
        return $next($request);
    }
}
