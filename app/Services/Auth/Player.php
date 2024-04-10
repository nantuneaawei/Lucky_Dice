<?php

namespace App\Services\Auth;

use App\Repositories\Mydb\Player as PlayerRepositories;
use App\Repositories\RedisRepository as RedisRepositories;
use App\Services\SessionService;

class Player
{
    private $oPlayerRepositories;
    private $oRedisRepositories;
    private $oSessionService;

    public function __construct(PlayerRepositories $_oPlayerRepositories, RedisRepositories $_oRedisRepositories, SessionService $_oSessionService)
    {
        $this->oPlayerRepositories = $_oPlayerRepositories;
        $this->oRedisRepositories = $_oRedisRepositories;
        $this->oSessionService = $_oSessionService;
    }

    public function registerResult($_bCreate)
    {
        if ($_bCreate) {
            return ['success' => true, 'message' => '註冊成功'];
        } else {
            return ['success' => false, 'message' => '註冊失敗'];
        }
    }

    public function loginPlayer($_aData)
    {
        $aPlayer = $this->oPlayerRepositories->findMemberByEmail($_aData['email']);

        if ($aPlayer != null) {
            if (password_verify($_aData['password'], $aPlayer['password'])) {
                $aUID = $this->generateUID();

                $this->oRedisRepositories->storeUIDs($aPlayer['id'], $aUID);

                $this->oSessionService->put('user_id', $aPlayer['id']);

                $this->oSessionService->put('user_name', $aPlayer['username']);

                return [
                    'state' => true,
                    'message' => '登入成功!',
                ];
            } else {
                return [
                    'state' => false,
                    'message' => '密碼錯誤!',
                ];
            }
        } else {
            return [
                'state' => false,
                'message' => '帳號不存在!',
            ];
        }
    }

    protected function generateUID()
    {
        $sUID = substr(sha1(uniqid('', true)), 1, 10);
        $sUID2 = substr(md5(uniqid('', true)), 3, 12);

        return [$sUID, $sUID2];
    }
}
