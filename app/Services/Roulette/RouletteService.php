<?php

namespace App\Services\Roulette;

use Illuminate\Support\Facades\Config;

class RouletteService
{
    protected $aSet;

    public function __construct()
    {
        $this->aSet = Config::get('wheel');
    }

    /**
     * getResult
     *
     * @return int|null
     */
    public function getResult()
    {
        $iRandomIndex = mt_rand(0, count($this->aSet) - 1);

        return $this->aSet[$iRandomIndex];
    }
}
