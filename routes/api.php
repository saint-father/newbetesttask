<?php

use App\Http\Controllers\Api\TickerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::match(array('GET', 'POST'), '', TickerController::class);
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('get-user', [AuthController::class, 'userInfo']);
    });
});
