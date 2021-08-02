<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Redpack\RandomCodeController;
use App\Http\Controllers\Redpack\SettingController;
use App\Http\Controllers\SalesmanController;
use App\Http\Controllers\ShareImageController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\SmsReportController;
use App\Http\Controllers\WechatMaterialController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WechatPushController;

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
// 默认显示登录页面
Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // 红包管理
    Route::name('redpack.')->group(function () {
        // 红包设置
        Route::get('setting/json', [SettingController::class, 'json'])->name('setting.json');
        Route::resource('setting', SettingController::class);

        // 随机码红包
        Route::get('randomCode/json', [RandomCodeController::class, 'json'])->name('randomCode.json');
        Route::resource('randomCode', RandomCodeController::class);
    });

    // 素材管理
    Route::name('material.')->group(function() {
        Route::get('wechatMaterial/json', [WechatMaterialController::class, 'json'])->name('wechatMaterial.json');
        Route::resource('wechatMaterial', WechatMaterialController::class);
    });

    // 活动管理
    Route::name('activity.')->group(function () {
        // 分享图片
        Route::get('shareImage/json', [ShareImageController::class, 'json'])->name('shareImage.json');
        Route::resource('shareImage', ShareImageController::class);

        // 新闻
        Route::get('news/json', [NewsController::class, 'json'])->name('news.json');
        Route::resource('news', NewsController::class);
    });

    // 客户管理
    Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('customer/json', [CustomerController::class, 'json'])->name('customer.json');

    // 短信管理
    Route::get('sms/json', [SmsController::class, 'json'])->name('sms.json');
    Route::post('sms/checkContent', [SmsController::class, 'checkContent'])->name('sms.checkContent');
    Route::resource('sms', SmsController::class);

    // 会所管理
    Route::get('club/json', [ClubController::class, 'json'])->name('club.json');
    Route::resource('club', ClubController::class);

    // 专属顾问
    Route::get('salesman/json', [SalesmanController::class, 'json'])->name('salesman.json');
    Route::resource('salesman', SalesmanController::class);

    // 户型管理
    Route::get('house/json', [HouseController::class, 'json'])->name('house.json');
    Route::post('house/storeImage', [HouseController::class, 'storeImage'])->name('house.storeImage');
    Route::resource('house', HouseController::class);

});

// 短信回调
Route::post('smsReport', SmsReportController::class);
// 微信服务器推送
Route::any('wechatPush', WechatPushController::class);
