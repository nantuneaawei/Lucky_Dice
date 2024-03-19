<?php

namespace Tests\Unit\Repositories;

use App\Models\Mydb\Player;
use App\Repositories\Mydb\Player as PlayerRepositories;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    protected $oPlayerRepositories;

    protected function setUp(): void
    {
        parent::setUp();

        $this->oPlayerRepositories = new PlayerRepositories(new Player());
    }

    /**
     * 测试当给定的玩家 ID 存在时，方法返回 true
     *
     * @return void
     */
    public function testHasPlayerReturnsTrueWhenPlayerExists()
    {
        // 创建一个玩家记录
        $oPlayer = Player::factory()->create();

        // 使用玩家 ID 调用方法
        $bResult = $this->oPlayerRepositories->hasPlayer($oPlayer->id);

        // 断言返回值为 true
        $this->assertTrue($bResult);
    }
}
