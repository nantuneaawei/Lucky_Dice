<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class RedisTest extends TestCase
{
    /**
     * Test Redis connection and set/get key.
     *
     * @return void
     */
    public function testRedisConnection()
    {
        Redis::set('test_key', 'test_value');

        $value = Redis::get('test_key');

        $this->assertEquals('test_value', $value);
    }
}
