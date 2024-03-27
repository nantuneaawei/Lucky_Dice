<?php

namespace App\Services\Roulette;

use App\Support\Facades\Random;
use Illuminate\Support\Facades\Config;

class RouletteService
{
    protected $aSet;

    public function __construct()
    {
        $this->aSet = Config::get('RouletteSet.wheel');
    }

    public function generateRoulette()
    {
        $iRandom = $this->getRandom();

        return $this->aSet[$iRandom];
    }

    private function getRandom()
    {
        $iMin = 0;
        $iMax = count($this->aSet) - 1;
        return Random::rand($iMin, $iMax);
    }
}
