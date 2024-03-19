<?php

namespace Tests\Unit\Services\Roulette;

use App\Services\Roulette\GameService;
use App\Repositories\Mydb\Player as PlayerReositories;
use Mockery;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    private $oGameService;
    private $oPlayerRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->oPlayerRepository = Mockery::mock(PlayerReositories::class);

        $this->oGameService = new GameService($this->oPlayerRepository);
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

        $this->oPlayerRepository->shouldReceive('getPlayerBalance')
            ->with($iPlayerId)
            ->andReturn($iBalance);

        $iBetAmount = 300;
        $bResult = $this->oGameService->placeBet($iPlayerId, $iBetAmount);
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

        $this->oPlayerRepository->shouldReceive('getPlayerBalance')
            ->with($iPlayerId)
            ->andReturn($iBalance);

        $iBetAmount = 700;
        $bResult = $this->oGameService->placeBet($iPlayerId, $iBetAmount);
        $this->assertFalse($bResult);
    }
}
