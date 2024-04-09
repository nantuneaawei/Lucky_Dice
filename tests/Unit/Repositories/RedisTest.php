<?php

namespace Tests\Unit\Repositories;

use App\Repositories\RedisRepository as RedisRepositories;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class RedisTest extends TestCase
{
    use RefreshDatabase;

    protected $oRedisRepositories;

    protected function setUp(): void
    {
        parent::setUp();

        $this->oRedisRepositories = new RedisRepositories();
    }
    
    /**
     * testStoreUIDInRedis
     *
     * @group redis
     * @return void
     */
    public function testStoreUIDInRedis()
    {
        $sKey = 'test_key';
        $sUid = substr(sha1(uniqid('', true)), 1, 10);

        $this->oRedisRepositories->storeUID($sKey, $sUid);

        $sStoredUID = Redis::get($sKey);

        $this->assertEquals($sUid, $sStoredUID);
    }
}
