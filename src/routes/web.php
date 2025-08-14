<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;

Route::middleware('auth')->group(function () {
    // Route::post('/', [ItemController::class, 'search']);
    Route::get('/mypage/profile',[ProfileController::class, 'edit']);
    Route::post('/mypage/profile',[ProfileController::class, 'update']);
    Route::get('/sell', [ItemController::class, 'sell']);
    Route::post('/sell', [ItemController::class, 'sell_register']);
    Route::get('/mypage', [ProfileController::class, 'profile']);
    Route::post('/mypage', [ProfileController::class, 'buyOrSell']);
});


    Route::get('/', [ItemController::class, 'index']);
    Route::post('/',[ItemController::class,'search']);
    Route::get('/item/{item_id}', [ItemController::class, 'item_detail']);