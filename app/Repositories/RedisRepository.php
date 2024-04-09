<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Redis;

class RedisRepository
{
    /**
     * 設定UID到Redis
     *
     * @param string $key
     * @param string $uid
     * @return void
     */
    public function storeUID(string $sKey, string $sUid)
    {
        Redis::set($sKey, $sUid);
    }

    /**
     * 從Redis中獲得UID
     *
     * @param string $key
     * @return string|null
     */
    public function getUID(string $sKey): ?string
    {
        return Redis::get($sKey);
    }
}