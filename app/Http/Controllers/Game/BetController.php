<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BetController extends Controller
{
    public function placeBet(Request $oRequest)
    {
        return response()->json(['message' => 'Bet placed successfully']);
    }
}
