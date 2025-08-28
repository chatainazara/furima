<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;

Route::middleware('auth')->group(function () {
    // Route::post('/', [ItemController::class, 'search']);
    Route::get('/mypage/profile',[ProfileController::class, 'edit']);
    Route::post('/mypage/profile',[ProfileController::class, 'update']);
    Route::get('/sell', [ItemController::class, 'sell']);
    Route::post('/sell', [ItemController::class, 'sell_register']);
    Route::get('/mypage', [ProfileController::class, 'profile']);
    Route::post('/mypage', [ProfileController::class, 'buyOrSell']);
    Route::get('/purchase/{item_id}',[PurchaseController::class,'purchaseView']);
    Route::post('/purchase/{item_id}',[PurchaseController::class,'purchase']);
    Route::get('/purchase/address/{item_id}',[PurchaseController::class,'destinationInput']);
    Route::post('/purchase/address/{item_id}',[PurchaseController::class,'destinationOrPaymentChange']);
    Route::post('/purchase',[PurchaseController::class,'purchase']);
});



    Route::get('/', [ItemController::class, 'index']);
    Route::post('/',[ItemController::class,'search']);
    Route::get('/item/{item_id}', [ItemController::class, 'item_detail_view']);
    Route::post('/item/{item_id}', [ItemController::class, 'item_detail']);


    Route::get('/phpinfo', function(){return view('/phpinfo');});