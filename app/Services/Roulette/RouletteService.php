<?php

namespace App\Services\Roulette;

use App\Support\Facades\Random;

class RouletteService
{
    protected $wheel = [
        0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36
    ];

    /**
     * Set the wheel array.
     *
     * @param array $wheel
     */
    public function setWheel(array $wheel)
    {
        $this->wheel = $wheel;
    }

    /**
     * generateRoulette
     *
     * 生產輪盤結果
     * @return array
     */
    public function generateRoulette()
    {
        $iRandom = $this->getRandom();

        $iResult = $this->wheel[$iRandom];

        $aResultDetails = $this->getResultDetails($iResult);

        return [
            'result' => $iResult,
            'details' => $aResultDetails,
        ];
    }

    /**
     * getRandom
     *
     * 生成隨機數
     * @return int
     */
    private function getRandom()
    {
        $iMin = 0;
        $iMax = count($this->wheel) - 1;
        return Random::rand($iMin, $iMax);
    }

    /**
     * getResultDetails
     *
     * 生成詳細結果
     * @param  int $_iResult
     * @return array
     */
    private function getResultDetails($_iResult)
    {
        $sOddEven = ($_iResult % 2 === 0) ? '偶數' : '奇數';
        $sColor = ($_iResult === 0) ? '綠色' : (($_iResult % 2 === 1) ? '紅色' : '黑色');

        return [
            'odd_even' => $sOddEven,
            'color' => $sColor,
        ];
    }
}
