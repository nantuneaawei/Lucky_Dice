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
}