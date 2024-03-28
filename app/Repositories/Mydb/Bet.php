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

    /**
     * 根據玩家ID和注單ID查詢下注紀錄
     *
     * @param int $_iPlayerId
     * @param int $_iBetId
     * @return array|null
     */
    public function getBetRecord($_iPlayerId, $_iBetId)
    {
        return $this->oBetModel::where('player_id', $_iPlayerId)
            ->where('bet_id', $_iBetId)
            ->first();
    }

    /**
     * 更新下注紀錄
     *
     * @param int $_iBetId
     * @param int $_iPlayerId
     * @param array $_aData
     * @return bool
     */
    public function updateBetRecord($_iPlayerId, $_iBetId, $_aData)
    {
        $iAffectedRows = $this->oBetModel::where('player_id', $_iPlayerId)
            ->where('bet_id', $_iBetId)
            ->update($_aData);

        return $iAffectedRows > 0;
    }


}
