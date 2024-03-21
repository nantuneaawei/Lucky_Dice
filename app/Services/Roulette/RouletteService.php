<?php

namespace App\Services\Roulette;

use Illuminate\Support\Facades\Config;

class RouletteService
{
    protected $aProbabilities;

    public function __construct()
    {
        $this->aProbabilities = Config::get('wheel');
    }
    
    /**
     * getResult
     *
     * @return void
     */
    public function getResult()
    {
        $iRandomNumber = mt_rand(1, 100) / 100;
        $iCumulativeProbability = 0;

        foreach ($this->aProbabilities as $iResult => $iProbability) {
            $iCumulativeProbability += $iProbability;
            if ($iRandomNumber <= $iCumulativeProbability) {
                return $iResult;
            }
        }

        return null;
    }
}