<?php

use App\Http\Controllers\admin\AgentController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\ClosingDayController;
use App\Http\Controllers\admin\CronController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\PaymentMethodController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\SlideController;
use App\Http\Controllers\admin\twod\ScheduleController;
use App\Http\Controllers\admin\twod\SectionController;
use App\Http\Controllers\admin\twod\TypeController;
use App\Http\Controllers\admin\threed\ScheduleController as ThreedScheduleController;
use App\Http\Controllers\admin\threed\SectionController as ThreedSectionController;
use App\Http\Controllers\TestController;
use App\Models\ClosingDay;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::group(['prefix' => 'admin', 'namspace' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'],function(){
    Route::controller(AuthController::class)->group(function(){
        Route::get('/register','register');
    });

    Route::get('/agent/pending', [AgentController::class, 'showPendings'])->name('agent.pendings');
    Route::get('agent/buy/pending',[AgentController::class,'showBuyingPendings'])->name('agent.buying.pendings');
    Route::get('agent/sell/pending', [AgentController::class, 'showSellingPendings'])->name('agent.selling.pendings');


    Route::get('/agent/{agent}/pending', [AgentController::class, 'showPending'])->name('agent.pending');
    Route::post('/agent/{agent}/approve', [AgentController::class, 'approve'])->name('agent.approve');
    Route::resource('agent',AgentController::class);

    Route::resource('payment_method',PaymentMethodController::class);

    Route::resource('customer',CustomerController::class);
    Route::group(['namepsace' => 'twod'],function(){
        Route::resource('twod_type',TypeController::class);
        Route::resource('twod_schedule', ScheduleController::class);
        Route::resource('twod_section', SectionController::class)->except('create','store');
        Route::post('twod_section/{twod_section}/numbers/update', [SectionController::class,'updateNumbersInfo'])->name('twod_section.number.update');
    });

    Route::group(['namepsace' => 'threed'], function () {
        Route::resource('threed_schedule', ThreedScheduleController::class);
        Route::resource('threed_section', ThreedSectionController::class)->except('create', 'store');
        Route::post('threed_section/{threed_section}/numbers/update', [ThreedSectionController::class, 'updateNumbersInfo'])->name('threed_section.number.update');
    });
    Route::get('dashboard',[DashboardController::class,'index']);

    Route::get('cron/twod_section/set',[CronController::class, 'set2DSections']);
    Route::resource('slide',SlideController::class);
    Route::resource('service', ServiceController::class);
    Route::resource('closing-day',ClosingDayController::class);
    Route::get('/setting',[SettingController::class,'index'])->name('setting.index');
    Route::post('/setting/update', [SettingController::class, 'update'])->name('setting.update');
    Route::post('/slide/home-banner-text/update', [SlideController::class, 'updateHomeBannerText'])->name('home-banner-text.update');



});

Route::get('test',[TestController::class,'index']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
