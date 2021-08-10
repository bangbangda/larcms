<?php

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

Route::namespace('App\Http\Controllers\API')->prefix('v1')->group(function () {
    Route::post('login', 'CustomerController@login')->name('miniApp.login');

    Route::get('home', 'HomeController@index')->name('home');
    Route::get('house/{house}', 'HouseController@show')->name('house.show');
    Route::get('salesman', 'SalesmanController@index')->name('salesman.index');
    Route::get('club', 'ClubController@index')->name('club.index');

    Route::middleware(['auth:sanctum'])->name('miniApp.')->group(function () {
        Route::get('shareImage', 'ShareImageController@index')->name('shareImage.index');
        Route::middleware('throttle:api-redpack')->post('randomCodeRedpack', 'HomeController@randomCodeRedpack')->name('home.randomCodeRedpack');
        Route::get('shareOrder', 'ShareOrderController@index')->name('shareOrder.index');
        Route::middleware('throttle:api-share')->post('shareOrder', 'ShareOrderController@store')->name('shareOrder.store');
        Route::get('customerIncome', 'CustomerIncomeController@index')->name('customerIncome');
        Route::get('activityRule', 'ActivityRuleController@index')->name('activityRule');
        Route::middleware('throttle:api-redpack')->post('decryptPhone', 'CustomerController@decryptPhone')->name('decryptPhone');
        Route::get('hasSubscribeMp', 'CustomerController@hasSubscribeMp')->name('hasSubscribeMp');
        Route::post('hasSubscribeMpByCode', 'CustomerController@hasSubscribeMpByCode')->name('hasSubscribeMpByCode');
        Route::get('my', 'CustomerController@show')->name('customerShow');
        Route::get('video', 'VideoController@index')->name('video');
    });

});
