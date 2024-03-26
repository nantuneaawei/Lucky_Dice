<?php

namespace App\Foundation;

class RandomTest
{
    public static $oMock;
    public function rand($_iMin, $_iMax)
    {
        return self::$oMock->rand($_iMin, $_iMax);
    }
}
