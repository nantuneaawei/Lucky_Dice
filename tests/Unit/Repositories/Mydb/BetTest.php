<?php

namespace Tests\Unit\Repositories\Mydb;

use App\Models\Mydb\Bet;
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
     * 測試根據 ID 查詢是否有下注紀錄
     *
     * @return void
     */
    public function testHasBetsForPlayerReturnsFalseWhenNoBetsExist()
    {
        $playerId = 1;

        $result = $this->oBetRepositories->hasBetsForPlayer($playerId);

        $this->assertFalse($result);
    }
}
