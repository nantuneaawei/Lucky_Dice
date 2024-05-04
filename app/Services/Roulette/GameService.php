<?php

namespace App\Services\Roulette;

use App\Repositories\Mydb\Bet as BetRepositories;
use App\Repositories\Mydb\Player as PlayerRepositories;

class GameService
{
    private $oPlayerRepositories;
    private $oBetRepositories;

    public function __construct(PlayerRepositories $_oPlayerRepositories, BetRepositories $_oBetRepositories)
    {
        $this->oPlayerRepositories = $_oPlayerRepositories;
        $this->oBetRepositories = $_oBetRepositories;
    }

    /**
     * 檢查餘額是否大於下注金額
     *
     * @param int $playerId
     * @param int $betAmount
     * @return bool
     */
    public function placeBet($_iPlayerId, $_iBetAmount)
    {
        $iPlayerBalance = $this->oPlayerRepositories->getPlayerBalance($_iPlayerId);

        if ($_iBetAmount <= $iPlayerBalance) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * addMultipleBetRecords
     * 新增多筆下注紀錄
     *
     * @param  array $_aBets
     * @return bool
     */
    public function addMultipleBetRecords($_aBets)
    {
        foreach ($_aBets as $aBet) {
            $bResult = $this->oBetRepositories->addBetRecord($aBet);

            if (!$bResult) {
                return false;
            }
        }
        return true;
    }
    /**
     * countTotalBetAmount
     * 計算下注總額
     *
     * @param  array $_aBet
     * @param  int $_iPlayerId
     * @return void
     */
    public function countTotalBetAmount($_aBet, $_iPlayerId)
    {
        $iTotalBetAmount = 0;
        foreach ($_aBet as &$aOneBet) {
            $aOneBet['player_id'] = $_iPlayerId;
            $iTotalBetAmount += $aOneBet['bet_amount'];
        }

        return $iTotalBetAmount;
    }
}
