<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GoodController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\StatusController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('good', GoodController::class)->only(['index']);
Route::middleware('auth:api')->group(function () {
    Route::apiResource('good', GoodController::class)->except(['index']);
    Route::apiResource('cart', CartController::class)->only(['index', 'show']);
    Route::apiResource('item', CartItemController::class)->only(['store', 'destroy']);
    Route::apiResource('order', OrderController::class);
    Route::apiResource('status', StatusController::class);
});
