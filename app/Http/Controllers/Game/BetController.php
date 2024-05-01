<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Repositories\mydb\Player as PlayerRepositories;
use App\Repositories\RedisRepository as RedisRepositories;
use App\Services\CookieService;
use App\Services\Roulette\GameService;
use App\Services\Roulette\RouletteService;
use Illuminate\Http\Request;

class BetController extends Controller
{
    protected $oPlayerRepositories;
    protected $oRedisRepositories;
    protected $oGameService;
    protected $oRouletteService;
    protected $oCookieService;

    public function __construct(PlayerRepositories $_oPlayerRepositories, RedisRepositories $_oRedisRepositories, GameService $_oGameService, RouletteService $_oRouletteService, CookieService $_oCookieService)
    {
        $this->oPlayerRepositories = $_oPlayerRepositories;
        $this->oRedisRepositories = $_oRedisRepositories;
        $this->oGameService = $_oGameService;
        $this->oRouletteService = $_oRouletteService;
        $this->oCookieService = $_oCookieService;
    }

    public function roulette()
    {
        return view('game.roulette');
    }

    public function placeBet(Request $oRequest)
    {
        $sCookieUID1 = $this->oCookieService->get('uid1');
        $sCookieUID2 = $this->oCookieService->get('uid2');
        $sUID1 = $this->getCryptCookie($sCookieUID1);
        $sUID2 = $this->getCryptCookie($sCookieUID2);
        $iPlayerId = $this->oRedisRepositories->getPlayerIdByCookieUIDs($sUID1, $sUID2);

        $aBet = $oRequest->all();

        $iTotalBetAmount = 0;
        foreach ($aBet as &$aOneBet) {
            $aOneBet['player_id'] = $iPlayerId;
            $iTotalBetAmount += $aOneBet['bet_amount'];
        }
        
        $bBetAmount = $this->oGameService->placeBet($iPlayerId, $iTotalBetAmount);
        if ($bBetAmount) {
            $bAddBetRecord = $this->oGameService->addMultipleBetRecords($aBet);
            if ($bAddBetRecord) {
                return response()->json(['status' => 'true', 'message' => '下注成功']);
            }
        } else {
            return response()->json(['status' => 'false', 'message' => '金額不足']);
        }
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
