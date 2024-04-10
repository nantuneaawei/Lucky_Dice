<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class ValidateUIDMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $oRequest, Closure $next): Response
    {
        $sessionUID = $oRequest->session()->get('uid');
        $redisUID = Redis::hget('uids:' . Auth::id(), 'uid1');

        if ($sessionUID && $redisUID && $sessionUID === $redisUID) {
            return $next($oRequest);
        } else {
            return redirect()->route('login');
        }
    }
}
