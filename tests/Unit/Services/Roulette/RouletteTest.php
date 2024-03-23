<?php

namespace Tests\Unit\Services\Roulette;

use App\Services\Roulette\RouletteService;
use Illuminate\Support\Facades\Config;
use Mockery;
use Tests\TestCase;

class RouletteTest extends TestCase
{
    protected $aWheel = [
        0, 5, 10, 15, 20, 25, 30, 35
    ];

    public function setUp(): void
    {
        parent::setUp();

        Config::set('wheel', $this->aWheel);
    }
            
    public function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * Test getResult method with custom data.
     *
     * @group roulette
     * @return void
     */
    public function testGetResultWithCustomData()
    {
        $iMockedRandomNumber = 2;

        $oRouletteService = Mockery::mock(RouletteService::class);
        $oRouletteService->shouldReceive('getResult')->andReturnUsing(function () use ($iMockedRandomNumber) {
            return $this->aWheel[$iMockedRandomNumber];
        });

        $iActual = $oRouletteService->getResult();

        $iExpected = 10;

        $this->assertEquals($iExpected, $iActual);
    }
}
