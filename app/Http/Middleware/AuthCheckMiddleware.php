<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $oRequest, Closure $next): Response
    {
        $iUid  = Session::get('uid1');
        $iUid2 = Session::get('uid2');
        $iLoginTime = Session::get('login_time');

        if ($iUid && $iUid2 && $iLoginTime && (time() - $iLoginTime) <= 3600) {
            return $next($oRequest);
        } else {
            return redirect('/login');
        }
    }
}
