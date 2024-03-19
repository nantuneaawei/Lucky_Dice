<?php

namespace App\Services\Roulette;

use App\Repositories\Mydb\Player as PlayerRepositories;

class GameService
{
    private $oPlayerRepositories;

    public function __construct(PlayerRepositories $_oPlayerRepositories)
    {
        $this->oPlayerRepositories = $_oPlayerRepositories;
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
}
