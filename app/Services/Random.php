<?php

namespace App\Services;

class Random
{
    public function generateRandomNumber($_iMix, $_iMax): int
    {
        return random_int($_iMix, $_iMax);
    }
}
