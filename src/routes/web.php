<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'index']);
});

Route::post('/mypage/profile',function(){
    return view('auth.profile');
});

Route::get('/mypage/profile',function(){
    return view('auth.profile');
});

Route::post('/',function(){
    return view('index');
});