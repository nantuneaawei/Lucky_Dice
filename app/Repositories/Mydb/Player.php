<?php

namespace App\Repositories\Mydb;

use App\Models\Mydb\Player as PlayerModel;

class Player
{
    private $oPlayerModel;

    public function __construct(PlayerModel $_oPlayerModel)
    {
        $this->oPlayerModel = $_oPlayerModel;
    }

    /**
     * 根據玩家 ID 獲取玩家餘額
     *
     * @param int $_iPlayerId
     * @return int|null
     */
    public function getPlayerBalance($_iPlayerId)
    {
        $iPlayer = $this->oPlayerModel::find($_iPlayerId);

        return $iPlayer ? $iPlayer->balance : null;
    }
}
