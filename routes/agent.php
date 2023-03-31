<?php

use App\Http\Controllers\agent\ApplyController;
use App\Http\Controllers\agent\AuthController;
use App\Http\Controllers\agent\BuyController;
use App\Http\Controllers\agent\SellController;
use App\Http\Controllers\agent\WithdrawController;
use App\Http\Resources\AgentResource;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'agent'],function(){
    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);

});

Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('/info', function (Request $request) {
        return new AgentResource($request->user());
    });
    Route::post('/apply/buy',[ApplyController::class, 'applyBuying']);
    Route::post('/apply/sell', [ApplyController::class, 'applySelling']);


    Route::get('/buying/list/',[BuyController::class,'getBuyingList']);
    Route::get('/buying/list/{transaction}', [BuyController::class, 'getBuyingTransactionDetail']);
    Route::post('/buying/list/{transaction}/confirm', [BuyController::class, 'confirmTransaction']);

    Route::get('/selling/list/', [SellController::class, 'getSellingList']);
    Route::get('/selling/list/{transaction}', [SellController::class, 'getSellingTransactionDetail']);
    Route::post('/selling/list/{transaction}/confirm', [SellController::class, 'confirmTransaction']);


});