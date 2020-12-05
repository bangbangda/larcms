<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('redpackBasis', RedpackBasisController::class);


Route::any('wechatPush', WechatPushController::class);
