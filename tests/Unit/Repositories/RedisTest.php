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
     * testGetUIDs
     *
     * @group redis
     * @return void
     */
    public function testGetUIDs()
    {
        $iUserId = 1;
        $aUids = ['uid1_value', 'uid2_value'];

        Redis::hset('uids:' . $iUserId, 'uid1', $aUids[0]);
        Redis::hset('uids:' . $iUserId, 'uid2', $aUids[1]);

        $aStoredUids = $this->oRedisRepositories->getUIDs($iUserId);

        $this->assertEquals($aUids, $aStoredUids);
    }
    
    /**
     * testGetUIDsEmptyArray
     *
     * @group redis
     * @return void
     */
    public function testGetUIDsEmptyArray()
    {
        $iUserId = 1;

        Redis::hdel('uids:' . $iUserId, 'uid1');
        Redis::hdel('uids:' . $iUserId, 'uid2');

        $aStoredUids = $this->oRedisRepositories->getUIDs($iUserId);

        $this->assertEquals([null, null], $aStoredUids);
    }
}
