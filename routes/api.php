<?php

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

Route::namespace('App\Http\Controllers\API')->prefix('v1')->group(function () {
    Route::post('login', 'CustomerController@login');


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('home', 'HomeController@index');
        Route::get('shareOrder', 'ShareOrderController@index');
        Route::get('customerIncome', 'CustomerIncomeController@index');
        Route::get('activityRule', 'ActivityRuleController@index');
    });

});
