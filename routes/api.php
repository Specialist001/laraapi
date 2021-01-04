<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GameController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('/games', GameController::class);

//Route::resource('/games', GameController::class)->only([
//    'index', 'show', 'store', 'update', 'destroy'
//]);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->name('api.logout');
    Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('api.login');
    Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register'])->name('api.register');
});
