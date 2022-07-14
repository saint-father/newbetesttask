<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use Alexfed\Categoryproducts\Http\Controllers\CategoryController;
use Alexfed\Categoryproducts\Http\Controllers\ProductController;

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
    Route::apiResource('products', ProductController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('get-user', [AuthController::class, 'userInfo']);
    Route::put('/assign-category/{productId}', [ProductController::class, 'assignCategory']);
});
