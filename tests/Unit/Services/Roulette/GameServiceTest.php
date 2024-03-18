<?php

namespace Tests\Unit\Services\Roulette;

use App\Services\Roulette\GameService;
use App\Repositories\Mydb\GameRepository;
use Mockery;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    private $gameService;
    private $gameRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->gameRepository = Mockery::mock(GameRepository::class);

        $this->gameService = new GameService($this->gameRepository);
    }

    /**
     * testBetAmountLessThanBalance
     * 下注金額小於玩家餘額
     *
     * @return void
     */
    public function testBetAmountLessThanBalance()
    {
        $iPlayerId = 1;
        $iBalance = 500;

        $this->gameRepository->shouldReceive('getPlayerBalance')
            ->with($iPlayerId)
            ->andReturn($iBalance);

        $iBetAmount = 300;
        $bResult = $this->gameService->placeBet($iPlayerId, $iBetAmount);
        $this->assertTrue($bResult);
    }
    
    /**
     * testBetAmountExceedsBalance
     * 下注金額大於玩家餘額
     *
     * @return void
     */
    public function testBetAmountExceedsBalance()
    {
        $iPlayerId = 1;
        $iBalance = 500;

        $this->gameRepository->shouldReceive('getPlayerBalance')
            ->with($iPlayerId)
            ->andReturn($iBalance);

        $iBetAmount = 700;
        $bResult = $this->gameService->placeBet($iPlayerId, $iBetAmount);
        $this->assertFalse($bResult);
    }
}
