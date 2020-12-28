<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ShareImageController;
use App\Http\Controllers\WechatMaterialController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RedpackSettingController;
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

    // 红包设置
    Route::get('redpack-setting/json', [RedpackSettingController::class, 'json'])->name('redpack-setting.json');
    Route::resource('redpack-setting', RedpackSettingController::class);

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
    });

    // 客户管理
    Route::get('customer/json', [CustomerController::class, 'json'])->name('customer.json');
    Route::resource('customer', CustomerController::class);
});



// 微信服务器推送
Route::any('wechatPush', WechatPushController::class);
