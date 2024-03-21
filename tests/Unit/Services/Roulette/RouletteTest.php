<?php

namespace Tests\Unit\Services\Roulette;

use App\Services\Roulette\RouletteService;
use Illuminate\Support\Facades\Config;
use Mockery;
use Tests\TestCase;

class RouletteTest extends TestCase
{
    private $oRouletteService;
    private $oRouletteMock;

    protected $aProbabilities = [
        0 => 20,
        1 => 10,
        2 => 10,
        3 => 10,
        4 => 10,
        5 => 10,
        6 => 10,
        7 => 10,
        8 => 10,
    ];

    public function setUp(): void
    {
        parent::setUp();

        Config::set('wheel', $this->aProbabilities);

        $this->oRouletteService = new RouletteService($this->aProbabilities);

        $this->oRouletteMock = Mockery::mock(RouletteService::class);
    }

    /**
     * testGetResultMatchesExpectation
     *
     * @group roulette
     * @return void
     */
    public function testGetResultMatchesExpectation()
    {
        $this->oRouletteMock->shouldReceive('getResult')->andReturn(1);

        $iActual = $this->oRouletteMock->getResult();

        $iExpected = 1;

        $this->assertEquals($iExpected, $iActual);
    }

}
