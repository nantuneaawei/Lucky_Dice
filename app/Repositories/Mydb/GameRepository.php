<?php

namespace App\Repositories\Mydb;

use App\Models\Mydb\Player;

class GameRepository
{
    /**
     * 根據玩家 ID 獲取玩家餘額
     *
     * @param int $playerId
     * @return int|null
     */
    public function getPlayerBalance($playerId)
    {
        $player = Player::find($playerId);

        return $player ? $player->balance : null;
    }
}
