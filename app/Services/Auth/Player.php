<?php

namespace App\Services\Auth;

use App\Repositories\Mydb\Player as PlayerRepositories;
use App\Repositories\RedisRepository as RedisRepositories;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class Player
{
    private $oPlayerRepositories;
    private $oRedisRepositories;

    public function __construct(PlayerRepositories $_oPlayerRepositories, RedisRepositories $_oRedisRepositories)
    {
        $this->oPlayerRepositories = $_oPlayerRepositories;
        $this->oRedisRepositories = $_oRedisRepositories;
    }

    public function registerResult($_bCreate)
    {
        if ($_bCreate) {
            return Response::json(['success' => true, 'message' => '註冊成功'], 200);
        } else {
            return Response::json(['success' => false, 'message' => '註冊失敗'], 422);
        }
    }

    public function loginPlayer($_aData)
    {
        $aPlayer = $this->oPlayerRepositories->findMemberByEmail($_aData['email']);

        if ($aPlayer != null) {
            if (password_verify($_aData['password'], $aPlayer['password'])) {
                $aUID = $this->generateUID();

                $this->oRedisRepositories->storeUIDs($aPlayer['id'], $aUID);

                

                Session::put('user_logged_in', true);
                Session::put('login_time', now());

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
