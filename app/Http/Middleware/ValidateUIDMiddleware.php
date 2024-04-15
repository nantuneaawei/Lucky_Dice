<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\CookieService;
use App\Services\SessionService;
use App\Repositories\RedisRepository;
use Symfony\Component\HttpFoundation\Response;

class ValidateUIDMiddleware
{
    private $oCookieService;
    private $oSessionService;
    private $oRedisRepository;

    public function __construct(CookieService $_oCookieService, SessionService $_oSessionService, RedisRepository $_oRedisRepository)
    {
        $this->oCookieService = $_oCookieService;
        $this->oSessionService = $_oSessionService;
        $this->oRedisRepository = $_oRedisRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $oRequest, Closure $next): Response
    {
        if ($this->oCookieService->has('uid1') && $this->oCookieService->has('uid2')) {
            $sCookieUid1 = $this->oCookieService->get('uid1');
            $sCookieUid2 = $this->oCookieService->get('uid2');

            $aRedisUids = $this->oRedisRepository->getUIDs($this->oSessionService->get('user_id'));

            if ($aRedisUids !== null && is_array($aRedisUids) && count($aRedisUids) === 2 &&
                $sCookieUid1 === $aRedisUids[0] && $sCookieUid2 === $aRedisUids[1]) {
                return $next($oRequest);
            }
        }

        return redirect('/login')->with('error', '請重新登錄');
    }
}
