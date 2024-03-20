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
     * 測試當玩家 ID 存在
     *
     * 回傳 true
     * @return void
     */
    public function testHasPlayerReturnsTrueWhenPlayerExists()
    {
        $oPlayer = Player::factory()->create();

        $bResult = $this->oPlayerRepositories->hasPlayer($oPlayer->id);

        $this->assertTrue($bResult);
    }
    
    /**
     * 測試當玩家 ID 不存在
     *
     * 回傳 false
     * @return void
     */
    public function testHasPlayerReturnsFalseWhenPlayerNotExists()
    {
        $iId = 999;
        
        $bResult = $this->oPlayerRepositories->hasPlayer($iId);

        $this->assertFalse($bResult);
    }
}
