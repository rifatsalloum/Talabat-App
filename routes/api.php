<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\ItemRateController;
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

Route::post("login",[UserController::class,"login"]);
Route::post("signup",[UserController::class,"store"]);

Route::get("country/all",[CountryController::class,"index"]);
Route::get("category/all",[ItemCategoryController::class,"index"]);
Route::get("payment/all",[PaymentController::class,"index"]);

Route::post("shop/search",[ShopController::class,"search"]);
Route::post("basket/add",[BasketController::class,"store"]);

Route::group(["middleware" => ["user-auth"]],function () {

    Route::get("order/all", [OrderController::class, "index"]);

    Route::post("order/place", [OrderController::class, "store"]);
    Route::post("rate/shop", [RateController::class, "store"]);
    Route::post("rate/shop/item", [ItemRateController::class, "store"]);

    Route::get("logout",[UserController::class,"logout"]);

});
