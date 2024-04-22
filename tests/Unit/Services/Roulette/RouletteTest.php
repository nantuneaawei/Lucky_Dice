<?php

namespace Tests\Unit\Services\Roulette;

use App\Foundation\RandomTest;
use App\Services\Roulette\RouletteService;
use App\Support\Facades\Facade;
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
        $this->setRandomMock($iMockRandom);

        $oRouletteService = new RouletteService();

        // 設置輪盤數組
        $oRouletteService->setWheel([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36]);

        $aResult = $oRouletteService->generateRoulette();

        $this->assertEquals($aExpected['result'], $aResult['result']);
        $this->assertEquals($aExpected['details']['odd_even'], $aResult['details']['odd_even']);
        $this->assertEquals($aExpected['details']['color'], $aResult['details']['color']);
    }

    /**
     * Data provider for testgenerateRoulette method.
     *
     * @return array
     */
    public static function getRandomData()
    {
        return [
            [0, ['result' => 0, 'details' => ['odd_even' => '偶數', 'color' => '綠色']]],
            [1, ['result' => 1, 'details' => ['odd_even' => '奇數', 'color' => '紅色']]],
        ];
    }
}
