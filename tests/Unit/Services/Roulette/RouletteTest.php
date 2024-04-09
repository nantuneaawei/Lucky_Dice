<?php

namespace Tests\Unit\Services\Roulette;

use App\Foundation\RandomTest;
use App\Services\Roulette\RouletteService;
use App\Support\Facades\Facade;
use Illuminate\Support\Facades\Config;
use Mockery;
use Tests\TestCase;

class RouletteTest extends TestCase
{
    protected function setRandomMock($iReturnValue)
    {
        $oMock = Mockery::mock(RandomTest::class);
        $oMock->shouldReceive('rand')->andReturn($iReturnValue);
        RandomTest::$oMock = $oMock;
    }

    /**
     * Set up the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // 清除 Facade 解析的實例，設置 Random Facade 的模擬實例
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication([
            'Random' => new RandomTest(),
        ]);
    }

    /**
     * Test generateRoulette
     *
     * @group random1
     * @dataProvider getRandomData
     * @param int $iMockRandom
     * @param array $aExpected
     */
    public function testgenerateRoulette($iMockRandom, $aExpected)
    {
        Mockery::resetContainer();

        $this->setRandomMock($iMockRandom);

        $aWheelConfig = [0, 5, 10, 15, 20, 25, 30, 35];
        Config::shouldReceive('get')->with('RouletteSet.wheel')->andReturn($aWheelConfig);

        $oBetRepository = Mockery::mock('overload:App\Repositories\Mydb\Bet_' . $iMockRandom);
        $oBetRepository->shouldReceive('addBetRecord')->once()->with(1, Mockery::type('int'));

        $oRouletteService = new RouletteService();
        $aResult = $oRouletteService->generateRoulette();

        $this->assertEquals($aExpected['result'], $aResult['result']);
        $this->assertEquals($aExpected['details']['odd_even'], $aResult['details']['odd_even']);
        $this->assertEquals($aExpected['details']['color'], $aResult['details']['color']);
    }

    /**
     * Data provider for testGetRandom method.
     *
     * @return array
     */
    public static function getRandomData()
    {
        return [
            [0, ['result' => 0, 'details' => ['odd_even' => '偶數', 'color' => '綠色']]],
            [1, ['result' => 5, 'details' => ['odd_even' => '奇數', 'color' => '紅色']]],
        ];
    }
}
