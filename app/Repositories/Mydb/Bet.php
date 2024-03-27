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

    /**
     * addBetRecords
     * 新增單個下注紀錄
     *
     * @param  array $_aBets
     * @return void
     */
    public function addBetRecord($_aBets)
    {
        return $this->oBetModel::create([
            'player_id' => $_aBets['player_id'],
            'bet_id' => $_aBets['bet_id'],
            'bet_type' => $_aBets['bet_type'],
            'bet_content' => $_aBets['bet_content'],
            'bet_amount' => $_aBets['bet_amount'],
        ]);
    }
}
