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

        $bExpected = false;

        $this->assertEquals($bExpected, $bResult);
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

        $bExpected = true;

        $this->assertEquals($bExpected, $bResult);
    }

    /**
     * 測試新增單個下注紀錄
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

    /**
     * 測試根據玩家ID和注單ID查詢下注紀錄
     *
     * @group bet
     * @return void
     */
    public function testgetBetRecord()
    {
        $oPlayer = Player::factory()->create();
        $oBetRecord = Bet::factory()->create([
            'player_id' => $oPlayer->id,
            'bet_id' => 1,
            'bet_type' => 'number',
            'bet_content' => '5',
            'bet_amount' => 100,
        ]);

        $aBetRecord = $this->oBetRepositories->getBetRecord($oPlayer->id, $oBetRecord->bet_id);

        $this->assertNotNull($aBetRecord);
        $this->assertEquals($oBetRecord->id, $aBetRecord->id);
    }

    /**
     * 測試更新下注紀錄，新增遊戲結果與損益結果
     *
     * @group bet
     * @return void
     */
    public function testUpdateBetRecord()
    {
        $oPlayer = Player::factory()->create();
        $oBetRecord = Bet::factory(3)->create([
            'player_id' => $oPlayer->id,
            'bet_id' => 1,
            'bet_type' => 'number',
            'bet_content' => rand(0, 36),
            'bet_amount' => 100,
        ]);

        $aData = [
            'game_result' => 0,
            'profit_loss' => -100,
        ];

        $bExpected = true;

        $bResult = $this->oBetRepositories->updateBetRecord($oPlayer->id, $oBetRecord->first()->bet_id, $aData);

        $oUpdatedBetRecords = Bet::where('player_id', $oPlayer->id)
            ->where('bet_id', $oBetRecord->first()->bet_id)
            ->get();

        $this->assertEquals($bExpected, $bResult);

        foreach ($oUpdatedBetRecords as $oUpdatedRecord) {
            $this->assertEquals($aData['game_result'], $oUpdatedRecord->game_result);
            $this->assertEquals($aData['profit_loss'], $oUpdatedRecord->profit_loss);
        }
    }
}
