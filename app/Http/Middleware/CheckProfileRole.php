<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckProfileRole
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
        /** @var \App\Models\Users\Profile $profile */
        $profile = $request->route('profile');

        if ($profile->user_id != Auth::id()) {
            return redirect()->route('profile.show', Auth::user()->profile);
        }

        return $next($request);
    }
}
