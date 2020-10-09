<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Lcobucci\JWT\Parser;
use Laravel\Passport\Token;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckDiscordBot
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
        try {
            $bearerToken = request()->bearerToken();
            $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
            $client = Token::find($tokenId)->client;
        } catch (Exception $e) {
            Log::error($e);
        }
        if ($client->id != config('app.discord_local_id')) {
            
            Log::info('Access to bot endpoint attempted', [
                'client' => $client,
                'user' => Auth::guard('api')->user(),
                'endpoint' => $request->getRequestUri(),
                'data' => $request->getContent(),
            ]);

            return response()->json([
                'message' => 'UNAUTHORIZED'
            ])->setStatusCode(401);
        }
        return $next($request);
    }
}
