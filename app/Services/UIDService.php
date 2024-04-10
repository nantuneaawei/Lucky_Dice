<?php

namespace App\Services;

class UIDService
{
    public function generateUID()
    {
        $sUID = substr(sha1(uniqid('', true)), 1, 10);
        $sUID2 = substr(md5(uniqid('', true)), 3, 12);

        return [$sUID, $sUID2];
    }
}
