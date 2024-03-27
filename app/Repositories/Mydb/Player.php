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
     * 檢查是否存在具有給定 ID 的玩家記錄
     *
     * @param int $_iPlayerId
     * @return bool
     */
    public function hasPlayer($_iPlayerId)
    {
        return $this->oPlayerModel::where('id', $_iPlayerId)->exists();
    }

    /**
     * 查詢玩家餘額
     *
     * @param  int $_iPlayerId
     * @return void
     */
    public function getPlayerBalance($_iPlayerId)
    {
        return $this->oPlayerModel::find($_iPlayerId)->balance;
    }
}
