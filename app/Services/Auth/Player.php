<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Response;

class Player
{
    public function registerResult($_bCreate)
    {
        if ($_bCreate) {
            return Response::json(['success' => true, 'message' => '註冊成功'], 200);
        } else {
            return Response::json(['success' => false, 'message' => '註冊失敗'], 422);
        }
    }
}