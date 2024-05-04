<?php

namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Random extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Random';
    }

    public static function rand($min, $max)
    {
        return rand($min, $max);
    }
}
