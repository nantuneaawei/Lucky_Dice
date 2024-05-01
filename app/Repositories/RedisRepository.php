<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Redis;

class RedisRepository
{
    /**
     * 設定UID到Redis
     *
     * @param int $_iUserId
     * @param array $_aUids
     * @return void
     */
    public function storeUIDs(int $_iUserId, array $_aUids)
    {
        Redis::hset('uids:' . $_iUserId, 'uid1', $_aUids[0]);
        Redis::hset('uids:' . $_iUserId, 'uid2', $_aUids[1]);
        Redis::expire('uids:' . $_iUserId, 3600);
    }

    /**
     * 從Redis中獲得UID
     *
     * @param int $_iUserId
     * @return array|null
     */
    public function getUIDs(int $_iUserId): ?array
    {
        return Redis::hmget('uids:' . $_iUserId, 'uid1', 'uid2');
    }

    /**
     * 根據UID1和UID2找到玩家ID
     *
     * @param string $_sUID1
     * @param string $_sUID2
     * @return int|null
     */
    public function getPlayerIdByCookieUIDs(string $_sCookieUID1, string $_sCookieUID2): ?int
    {
        $aAllUIDsData = $this->getAllUIDsData();

        foreach ($aAllUIDsData as $sKey => $aData) {
            if ($aData['uid1'] === $_sCookieUID1 && $aData['uid2'] === $_sCookieUID2) {
                $iUserId = substr($sKey, strrpos($sKey, ':') + 1);
                return $iUserId;
            }
        }

        return null;
    }

    /**
     * 查詢所有以 "uids:" 開頭的資料
     *
     * @return array
     */
    protected function getAllUIDsData(): array
    {
        $sPattern = 'uids:*';
        $aKeys = Redis::keys($sPattern);

        $aData = [];

        foreach ($aKeys as $sKey) {
            $iUserId = substr($sKey, strrpos($sKey, ':') + 1);
            $aData[$sKey] = [
                'uid1' => Redis::hget('uids:' . $iUserId, 'uid1'),
                'uid2' => Redis::hget('uids:' . $iUserId, 'uid2'),
            ];
        }

        return $aData;
    }

}
