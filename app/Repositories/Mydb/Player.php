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
    
    /**
     * createMember
     *
     * @param  array $_aData
     * @return void
     */
    public function createMember($_aData)
    {
        return $this->oPlayerModel->create([
            'username' => $_aData['username'],
            'email' => $_aData['email'],
            'password' => password_hash($_aData['password'], PASSWORD_DEFAULT),
        ]);
    }
    
    /**
     * findMemberByEmail
     *
     * @param  string $_sEmail
     * @return void
     */
    public function findMemberByEmail($_sEmail)
    {
        return $this->oPlayerModel->where('email', $_sEmail)
            ->first()
            ->toArray();
    }
}
