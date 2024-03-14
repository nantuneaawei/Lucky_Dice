<?php

namespace Tests\Unit\Repositories;

use App\Models\Mydb\Player;
use App\Repositories\Mydb\GameRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $gameRepository;

    protected function setUp(): void
    {
        parent::setUp();

        Player::factory()->count(1)->create();

        $this->gameRepository = new GameRepository();
    }

    /**
     * 測試根據玩家 ID 獲取玩家餘額是否正確
     *
     * @return void
     */
    public function testGetPlayerBalanceById()
    {
        $playerId = Player::first()->id;

        $playerBalance = $this->gameRepository->getPlayerBalance($playerId);

        $this->assertEquals(1000, $playerBalance);
    }
}
