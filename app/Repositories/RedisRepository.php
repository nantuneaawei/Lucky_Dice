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
}