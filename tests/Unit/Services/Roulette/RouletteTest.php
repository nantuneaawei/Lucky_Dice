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
    protected function setRandomMock($returnValue)
    {
        $mock = Mockery::mock(RandomTest::class);
        $mock->shouldReceive('rand')->andReturn($returnValue);
        RandomTest::$oMock = $mock;
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
     * Test getRandom method of RouletteService.
     *
     * @group random1
     * @dataProvider getRandomData
     * @param int $expected
     */
    public function testGetRandom($expected)
    {
        $this->setRandomMock($expected);

        $wheelConfig = [0, 5, 10, 15, 20, 25, 30, 35];
        Config::shouldReceive('get')->with('RouletteSet.wheel')->andReturn($wheelConfig);

        $rouletteService = new RouletteService();
        $result = $rouletteService->getRandom();

        $this->assertEquals($expected, $result);
    }

    /**
     * Data provider for testGetRandom method.
     *
     * @return array
     */
    public static function getRandomData()
    {
        return [
            [5],
            [10],
        ];
    }
}
