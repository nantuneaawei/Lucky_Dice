<?php

namespace App\Services\Auth;

use App\Repositories\Mydb\Player as PlayerRepositories;
use App\Repositories\RedisRepository as RedisRepositories;
use App\Services\SessionService;
use App\Services\CookieService;
use App\Services\UIDService;

class Player
{
    private $oPlayerRepositories;
    private $oRedisRepositories;
    private $oSessionService;
    private $oCookieService;
    private $oUIDService;

    public function __construct(PlayerRepositories $_oPlayerRepositories, RedisRepositories $_oRedisRepositories, SessionService $_oSessionService, CookieService $_oCookieService, UIDService $_oUIDService)
    {
        $this->oPlayerRepositories = $_oPlayerRepositories;
        $this->oRedisRepositories = $_oRedisRepositories;
        $this->oSessionService = $_oSessionService;
        $this->oCookieService = $_oCookieService;
        $this->oUIDService = $_oUIDService;
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
                $aUID = $this->oUIDService->generateUID();

                $this->oRedisRepositories->storeUIDs($aPlayer['id'], $aUID);

                $this->setUIDCookie($aUID);

                return [
                    'state' => true,
                    'message' => '登入成功!',
                    'uid1' => $aUID[0],
                    'uid2' => $aUID[1],
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

    protected function setUIDCookie($_aUID)
    {
        $iMinutes = 60;
        $this->oCookieService->put('uid1', $_aUID[0], $iMinutes);
        $this->oCookieService->put('uid2', $_aUID[1], $iMinutes);
    }
}
