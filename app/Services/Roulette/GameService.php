<?php

namespace App\Services\Roulette;

use App\Repositories\Mydb\GameRepository as GameRepositories;

class GameService
{
    private $oGameRepositories;

    public function __construct(GameRepositories $_oGameRepositories)
    {
        $this->oGameRepositories = $_oGameRepositories;
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
        $iPlayerBalance = $this->oGameRepositories->getPlayerBalance($_iPlayerId);

        if ($_iBetAmount <= $iPlayerBalance) {
            return true;
        } else {
            return false;
        }
    }
}
