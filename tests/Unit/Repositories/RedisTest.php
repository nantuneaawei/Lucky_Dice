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
     * testStoreUIDs
     *
     * @group redis
     * @return void
     */
    public function testStoreUIDs()
    {
        $iUserId = 1;
        $aUids = ['uid1_value', 'uid2_value'];

        $this->oRedisRepositories->storeUIDs($iUserId, $aUids);

        $sStoredUid1 = Redis::hget('uids:' . $iUserId, 'uid1');
        $sStoredUid2 = Redis::hget('uids:' . $iUserId, 'uid2');

        $this->assertEquals($aUids[0], $sStoredUid1);
        $this->assertEquals($aUids[1], $sStoredUid2);
    }
    
    /**
     * testGetUIDFromRedis
     *
     * @group redis
     * @return void
     */
    public function testGetUIDFromRedis()
    {
        $sKey = 'test_key';
        $sUid = substr(md5(uniqid('', true)), 3, 12);

        Redis::set($sKey, $sUid);

        $sStoredUID = $this->oRedisRepositories->getUID($sKey);

        $this->assertEquals($sUid, $sStoredUID);
    }
}
