<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class SessionService
{
    public function put($_sKey, $_sValue)
    {
        Session::put($_sKey, $_sValue);
    }

    public function get($_sKey, $_sDefault = null)
    {
        return Session::get($_sKey, $_sDefault);
    }

    public function forget($_sKey)
    {
        Session::forget($_sKey);
    }

    public function regenerate()
    {
        Session::regenerate();
    }

    public function flush()
    {
        Session::flush();
    }
}
