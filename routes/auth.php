<?php

use App\Http\Controllers\Game\BetController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/roulette', [BetController::class, 'roulette']);
});