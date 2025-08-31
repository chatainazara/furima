<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;

Route::middleware('auth')->group(function () {
    Route::get('/mypage/profile',[ProfileController::class, 'edit']);
    Route::post('/mypage/profile',[ProfileController::class, 'update']);
    Route::get('/sell', [ItemController::class, 'sell']);
    Route::post('/sell', [ItemController::class, 'sellRegister']);
    Route::get('/mypage', [ProfileController::class, 'profile']);
    Route::post('/mypage', [ProfileController::class, 'buyOrSell']);
    Route::get('/purchase/{item_id}',[PurchaseController::class,'purchaseView']);
    Route::get('/purchase/address/{item_id}',[PurchaseController::class,'destinationInput']);
    Route::post('/purchase/address/{item_id}',[PurchaseController::class,'destinationOrPaymentChange']);
    Route::post('/purchase',[PurchaseController::class,'purchase']);
});

Route::get('/', [ItemController::class, 'index']);
Route::post('/',[ItemController::class,'searchAndMylist']);
Route::get('/item/{item_id}', [ItemController::class, 'itemDetailView']);
Route::post('/item/{item_id}', [ItemController::class, 'itemDetail']);

Route::get('/phpinfo', function(){return view('/phpinfo');});