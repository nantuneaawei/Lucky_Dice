<?php

namespace Tests\Unit\Services\Roulette;

use App\Services\Roulette\RouletteService;
use App\Foundation\RandomTest;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use App\Support\Facades\Facade;

class RouletteTest extends TestCase
{    
    /**
     * Set up the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // 清除 Facade 解析的实例，设置 Random Facade 的模拟实例
        Facade::clearResolvedInstances();
        $aFacades['Random'] = new RandomTest();
        Facade::setFacadeApplication($aFacades);
    }

    /**
     * Test getRandom method of RouletteService.
     *
     * @group random1
     * @return void
     */
    public function testGetRandom()
    {
        $wheelConfig = [0, 5, 10, 15, 20, 25, 30, 35];
        Config::shouldReceive('get')
            ->with('RouletteSet.wheel')
            ->andReturn($wheelConfig);

        $oMock = \Mockery::mock(RandomTest::class);
        $oMock->shouldReceive('rand')
            ->andReturn(5);
        RandomTest::$oMock = $oMock;

        $rouletteService = new RouletteService();
        $result = $rouletteService->getRandom();

        $this->assertEquals(5, $result);
    }
}
