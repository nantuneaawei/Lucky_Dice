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
     * 玩家下注
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

}
