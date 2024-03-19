<?php

namespace App\Repositories\Mydb;

use App\Models\Mydb\Bet as BetModel;

class Bet
{
    private $oBetModel;

    public function __construct(BetModel $_oBetModel)
    {
        $this->oBetModel = $_oBetModel;
    }
    
    /**
     * hasBetsForPlayer
     * 根據 ID 查詢有無下注紀錄
     *
     * @param  int $_iPlayerId
     * @return void
     */
    public function hasBetsForPlayer($_iPlayerId)
    {
        return $this->oBetModel::where('player_id', $_iPlayerId)->exists();
    }
}
