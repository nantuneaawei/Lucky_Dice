<?php

namespace Tests\Unit;

use App\Services\Random;
use PHPUnit\Framework\TestCase;

class RandomTest extends TestCase
{
    /**
     * @test
     * @group random
     * @dataProvider randomNumberProvider
     */
    public function it_generates_random_number_within_range($iMin, $iMax, $bExpected)
    {
        $oRandom = new Random();
        $iResult = $oRandom->generateRandomNumber($iMin, $iMax);

        $this->assertGreaterThanOrEqual($iMin, $iResult);
        $this->assertLessThanOrEqual($iMax, $iResult);
    }

    public static function randomNumberProvider()
    {
        return [
            'positive range' => [1, 10, true],
            'negative range' => [-10, -1, true],
            'zero range' => [0, 0, true],
            'mixed range' => [-5, 5, true],
        ];
    }
}
