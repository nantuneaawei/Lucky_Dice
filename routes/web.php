<?php

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

Route::get('/', function () {
    return view('game.roulette');
});

Route::view('/register', 'auth.register');

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
        ],
    ];
});

Route::get('/{any}', 'App\Http\Controllers\Auth\AuthController@index')->where('any', '.*');