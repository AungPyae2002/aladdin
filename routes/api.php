<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CommonController;
use App\Http\Controllers\api\DepositController;
use App\Http\Controllers\api\NotificationController;
use App\Http\Controllers\api\ThreeDController;
use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\api\TwoDController;
use App\Http\Controllers\api\WithdrawController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/customer/info', function (Request $request) {
        return $request->user();
    });
    Route::post('twod_section/{twod_section}/bet', [TwoDController::class, 'bet']);
    Route::get('twod/betting_log', [TwoDController::class, 'getBettingLog']);
    Route::get('twod/betting_log/{date}', [TwoDController::class, 'getBettingLogByDate']);

    Route::post('threed_section/{threed_section}/bet', [ThreeDController::class, 'bet']);
    Route::get('threed/betting_log', [ThreeDController::class, 'getBettingLog']);
    Route::get('threed/betting_log/{date}', [ThreeDController::class, 'getBettingLogByDate']);

    Route::get('/notification',[NotificationController::class,'getAllNotifications']);
    Route::get('/transaction', [TransactionController::class, 'getAllTransactions']);

    Route::post('/agent/withdaw/{agent}/confirm', [WithdrawController::class, 'submit']);
    Route::post('/agent/deposit/{agent}/confirm', [DepositController::class, 'submit']);

    Route::post('/profile/update',[AuthController::class,'updateProfile']);

});
Route::get('/agent/withdraw/{amount}', [WithdrawController::class, 'getAgents']);
Route::get('/agent/withdraw/{agent}/info',[WithdrawController::class,'getAgentInfo']);

Route::get('/agent/deposit/{amount}', [DepositController::class, 'getAgents']);
Route::get('/agent/deposit/{agent}/info', [DepositController::class, 'getAgentInfo']);


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('twod_section', [TwoDController::class, 'getSections']);
Route::get('twod_section/{twod_section}', [TwoDController::class, 'getSection']);

Route::get('threed_section/history', [ThreeDController::class, 'getHistory']);
Route::get('threed_section',[ThreeDController::class,'checkSection']);
Route::get('threed_section/{threed_section}', [ThreeDController::class, 'getSection']);

Route::get('/slide',[CommonController::class,'getSlides']);
Route::get('/service',[CommonController::class,'getServices']);
Route::get('/payment-method', [CommonController::class, 'getPaymentMethods']);
Route::get('/closing-day', [CommonController::class, 'getClosingDays']);




