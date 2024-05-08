<?php

namespace Tests\Unit\Services\Roulette;

use App\Repositories\Mydb\Bet as BetRepositories;
use App\Repositories\Mydb\Player as PlayerReositories;
use App\Services\Roulette\GameService;
use Mockery;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    private $oGameService;
    private $oPlayerRepository;
    private $oBetRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->oPlayerRepository = Mockery::mock(PlayerReositories::class);

        $this->oBetRepository = Mockery::mock(BetRepositories::class);

        $this->oGameService = new GameService($this->oPlayerRepository, $this->oBetRepository);
    }

    /**
     * testBetAmountLessThanBalance
     * 下注金額小於玩家餘額
     *
     * @group game
     * @return void
     */
    public function testBetAmountLessThanBalance()
    {
        $iPlayerId = 1;
        $iBalance = 500;
        $iBetAmount = 300;

        $this->oPlayerRepository->shouldReceive('getPlayerBalance')
            ->with($iPlayerId)
            ->andReturn($iBalance);

        $this->oBetRepository->shouldNotReceive('addBetRecord');

        $bActual = $this->oGameService->checkAmount($iPlayerId, $iBetAmount);

        $bExpected = true;

        $this->assertEquals($bExpected, $bActual);
    }

    /**
     * testBetAmountExceedsBalance
     * 下注金額大於玩家餘額
     *
     * @group game
     * @return void
     */
    public function testBetAmountExceedsBalance()
    {
        $iPlayerId = 1;
        $iBalance = 500;

        $this->oPlayerRepository->shouldReceive('getPlayerBalance')
            ->with($iPlayerId)
            ->andReturn($iBalance);

        $this->oBetRepository->shouldNotReceive('addBetRecord');

        $iBetAmount = 700;
        $bActual = $this->oGameService->checkAmount($iPlayerId, $iBetAmount);
        $bExpected = false;

        $this->assertEquals($bExpected, $bActual);
    }

    /**
     * testAddMultipleBetRecords
     * 新增多筆下注紀錄
     * 下注兩筆
     * @group game
     * @return void
     */
    public function testAddMultipleBetRecords()
    {
        $aBets = [
            [
                'player_id' => 1,
                'bet_type' => 'number',
                'bet_content' => '5',
                'bet_amount' => 100,
            ],
            [
                'player_id' => 1,
                'bet_type' => 'color',
                'bet_content' => 'red',
                'bet_amount' => 200,
            ],
        ];

        $this->oBetRepository->shouldReceive('addBetRecord')
            ->times(count($aBets))
            ->with(Mockery::on(function ($bet) {
                return isset($bet['player_id']) && isset($bet['bet_type']) && isset($bet['bet_content']) && isset($bet['bet_amount']);
            }))
            ->andReturn(true);

        $bActual = $this->oGameService->addMultipleBetRecords($aBets);

        $bExpected = true;

        $this->assertEquals($bExpected, $bActual);
    }

    /**
     * testAddMultipleBetRecords
     * 新增多筆下注紀錄
     * 當只有一筆下注
     * @group game
     * @return void
     */
    public function testAddMultipleBetRecords2()
    {
        $aBets = [
            [
                'player_id' => 1,
                'bet_type' => 'number',
                'bet_content' => '5',
                'bet_amount' => 100,
            ],
        ];

        $this->oBetRepository->shouldReceive('addBetRecord')
            ->times(count($aBets))
            ->with(Mockery::on(function ($bet) {
                return isset($bet['player_id']) && isset($bet['bet_type']) && isset($bet['bet_content']) && isset($bet['bet_amount']);
            }))
            ->andReturn(true);

        $bActual = $this->oGameService->addMultipleBetRecords($aBets);

        $bExpected = true;

        $this->assertEquals($bExpected, $bActual);
    }

    /**
     * testAddMultipleBetRecordsFailure
     * 新增多筆下注紀錄 - 失敗情況
     * 下注兩筆，其中一筆新增失敗
     * @group game
     * @return void
     */
    public function testAddMultipleBetRecordsFailure()
    {
        $aBets = [
            [
                'player_id' => 1,
                'bet_type' => 'number',
                'bet_content' => '5',
                'bet_amount' => 100,
            ],
            [

            ],
        ];

        $this->oBetRepository->shouldReceive('addBetRecord')
            ->times(count($aBets))
            ->andReturnUsing(function ($bet) {
                return isset($bet['player_id']) && isset($bet['bet_type']) && isset($bet['bet_content']) && isset($bet['bet_amount']);
            });

        $bActual = $this->oGameService->addMultipleBetRecords($aBets);

        $bExpected = false;

        $this->assertEquals($bExpected, $bActual);
    }

    /**
     * testCountTotalBetAmount
     * 計算下注總額並加入ID
     *
     * @group game
     * @return void
     */
    public function testCountTotalBetAmount()
    {
        $aBet = [
            ['bet_amount' => 100],
            ['bet_amount' => 200],
            ['bet_amount' => 300],
        ];
        $iPlayerId = 1;

        $aResult = $this->oGameService->countTotalBetAmount($aBet, $iPlayerId);

        $iExpectedTotalBetAmount = 600;
        $aExpectedModifiedBet = [
            ['bet_amount' => 100, 'player_id' => 1],
            ['bet_amount' => 200, 'player_id' => 1],
            ['bet_amount' => 300, 'player_id' => 1],
        ];

        $this->assertEquals($iExpectedTotalBetAmount, $aResult['total_bet_amount']);
        $this->assertEquals($aExpectedModifiedBet, $aResult['bets']);
    }

    public function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

}
