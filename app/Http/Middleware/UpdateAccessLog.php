<?php

namespace App\Http\Middleware;

use App\Models\Users\AccessLog;
use Closure;
use Illuminate\Support\Facades\Auth;

class UpdateAccessLog
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
        if(Auth::guest()) {
            return $next($request);
        } else {
            $ip = $request->ip();
            $log = AccessLog::where('user_id', Auth::id())->where('ip', $ip)->first();
            if ($log) {
                $log->touch();
                return $next($request);
            } else {
                AccessLog::create([
                    'user_id' => Auth::id(),
                    'ip' => $ip
                ]);
                return $next($request);
            }
        }
    }
}
