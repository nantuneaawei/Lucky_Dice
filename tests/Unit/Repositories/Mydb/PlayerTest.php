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
     * 測試根據玩家 ID 獲取玩家餘額是否正確
     *
     * @return void
     */
    public function testGetPlayerBalanceById()
    {
        $oPlayer = Player::factory()->create(['balance' => 1000]);

        $iPlayerId = $oPlayer->id;

        $iPlayerBalance = $this->oPlayerRepositories->getPlayerBalance($iPlayerId);

        $this->assertEquals(1000, $iPlayerBalance);
    }
}
