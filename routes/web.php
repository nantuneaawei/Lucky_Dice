<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Game\BetController;
use App\Http\Middleware\ValidateUIDMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::middleware([ValidateUIDMiddleware::class])->group(function () {
    Route::get('/roulette', [BetController::class, 'roulette']);
});

Route::get('/api/routes', function () {
    return [
        'routes' => [
            [
                'path' => '/login',
                'component' => 'Login',
            ],
            [
                'path' => '/register',
                'component' => 'Register',
            ],
            [
                'path' => '/roulette',
                'component' => 'Roulette',
            ],
        ],
    ];
});

Route::get('/{any}', [AuthController::class, 'index'])->where('any', '.*');