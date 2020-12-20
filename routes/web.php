<?php

use App\Http\Controllers\WechatMaterialController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RedpackBasisController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // 红包设置
    Route::name('redpack.')->group(function () {
        // 基础红包
        Route::get('redpackBasis', [RedpackBasisController::class, 'index'])->name('basis');
    });

    // 素材管理
    Route::name('material.')->group(function() {
        Route::get('wechatMaterial/json', [WechatMaterialController::class, 'json'])->name('wechatMaterial.json');
        Route::resource('wechatMaterial', WechatMaterialController::class);
    });

});



// 微信服务器推送
Route::any('wechatPush', WechatPushController::class);
