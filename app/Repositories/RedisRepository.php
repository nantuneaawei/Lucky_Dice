<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Redis;

class RedisRepository
{
    /**
     * 設定UID到Redis
     *
     * @param int $userId
     * @param array $uids
     * @return void
     */
    public function storeUIDs(int $userId, array $uids)
    {
        Redis::hset('uids:' . $userId, 'uid1', $uids[0]);
        Redis::hset('uids:' . $userId, 'uid2', $uids[1]);
    }

    /**
     * 從Redis中獲得UID
     * 
     * @param int $userId
     * @return array|null
     */
    public function getUIDs(int $userId): ?array
    {
        return Redis::hmget('uids:' . $userId, 'uid1', 'uid2');
    }
}