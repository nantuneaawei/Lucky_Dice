<?php

namespace App\Services;

use Illuminate\Support\Facades\Cookie;

class CookieService
{
    public function put($_sKey, $_sValue, $_iMinutes = 60)
    {
        Cookie::queue($_sKey, $_sValue, $_iMinutes);
    }

    public function get($_sKey, $_sDefault = null)
    {
        return Cookie::get($_sKey, $_sDefault);
    }

    public function forget($_sKey)
    {
        Cookie::queue(Cookie::forget($_sKey));
    }

    public function has($_sKey)
    {
        return Cookie::has($_sKey);
    }
}
