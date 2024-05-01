<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Repositories\mydb\Player as PlayerRepositories;
use App\Services\CookieService;
use App\Services\Roulette\GameService;
use App\Services\Roulette\RouletteService;
use App\Services\SessionService;
use Illuminate\Http\Request;

class BetController extends Controller
{
    protected $oPlayerRepositories;
    protected $oGameService;
    protected $oRouletteService;
    protected $oCookieService;
    protected $oSessionService;

    public function __construct(PlayerRepositories $_oPlayerRepositories, GameService $_oGameService, RouletteService $_oRouletteService, CookieService $_oCookieService, SessionService $_oSessionService)
    {
        $this->oPlayerRepositories = $_oPlayerRepositories;
        $this->oGameService = $_oGameService;
        $this->oRouletteService = $_oRouletteService;
        $this->oCookieService = $_oCookieService;
        $this->oSessionService = $_oSessionService;
    }

    public function roulette()
    {
        return view('game.roulette');
    }

    public function placeBet(Request $oRequest)
    {
        $iUID1 = $this->oCookieService->get('uid1');
        $iData = $this->getCryptCookie($iUID1);
        dd($iData);
        return response()->json(['message' => 'Bet placed successfully']);
    }

    protected function checkUserAuthentication($_oRequest)
    {
        if ($_oRequest->hasCookie('uid1') && $_oRequest->hasCookie('uid2')) {
            return true;
        } else {
            return false;
        }
    }

    protected function getCryptCookie($_iCookie)
    {
        $iDecrypt = decrypt($_iCookie, false);
        $iAssort = explode('|', $iDecrypt);
        return $iAssort[1];
    }
}
