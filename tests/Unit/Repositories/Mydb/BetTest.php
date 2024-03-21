<?php

namespace Tests\Unit\Repositories\Mydb;

use App\Models\Mydb\Bet;
use App\Models\Mydb\Player;
use App\Repositories\Mydb\Bet as BetRepositories;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BetTest extends TestCase
{
    use RefreshDatabase;

    protected $oBetRepositories;

    protected function setUp(): void
    {
        parent::setUp();

        $this->oBetRepositories = new BetRepositories(new Bet());
    }

    /**
     * 測試當玩家 ID 不存在 Bet
     *
     * @group bet
     * @return void
     */
    public function testHasBetsForPlayerReturnsFalseWhenNoBetsExist()
    {
        $iPlayerId = 1;

        $bResult = $this->oBetRepositories->hasBetsForPlayer($iPlayerId);

        $this->assertFalse($bResult);
    }

    /**
     * 測試當玩家 ID 存在 Bet
     *
     * @group bet
     * @return void
     */
    public function testHasBetsForPlayerReturnstrueWhenBetsExist()
    {
        $oPlayer = Bet::factory()->create();

        $bResult = $this->oBetRepositories->hasBetsForPlayer($oPlayer->id);

        $this->assertTrue($bResult);
    }

    /**
     * 測試新增下注紀錄
     *
     * @group bet
     * @return void
     */
    public function testAddBetRecord()
    {
        $oPlayer = Player::factory()->create();

        $aBets = [
            'player_id' => $oPlayer->id,
            'bet_id' => 1,
            'bet_type' => 'number',
            'bet_content' => '5',
            'bet_amount' => 100,
        ];

        $bResult = $this->oBetRepositories->addBetRecord($aBets)->exists;

        $bExpected = true;

        $this->assertEquals($bExpected, $bResult);
    }
}
