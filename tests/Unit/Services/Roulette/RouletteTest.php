<?php

namespace Tests\Unit\Services\Roulette;

use App\Services\Roulette\RouletteService;
use App\Foundation\RandomTest;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use App\Support\Facades\Facade;
use Mockery;

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
     * TestgenerateRoulette
     *
     * @group random1
     * @dataProvider getRandomData
     * @param int $expected
     */
    public function testgenerateRoulette($iMockRandom, $iExpected)
    {
        $this->setRandomMock($iMockRandom);

        $aWheelConfig = [0, 5, 10, 15, 20, 25, 30, 35];
        Config::shouldReceive('get')->with('RouletteSet.wheel')->andReturn($aWheelConfig);

        $oRouletteService = new RouletteService();
        $iResult = $oRouletteService->generateRoulette();

        $this->assertEquals($iExpected, $iResult);
    }

    /**
     * Data provider for testGetRandom method.
     *
     * @return array
     */
    public static function getRandomData()
    {
        return [
            [0, 0],
            [1, 5],
        ];
    }
}
