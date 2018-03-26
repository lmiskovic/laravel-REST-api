<?php

use Illuminate\Http\Request;

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

Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::post('refresh', 'Api\Auth\LoginController@refresh');

Route::middleware('auth:api')->group(function () {
	Route::post('updateDelivery', 'Api\DeliveryController@updateDelivery')->middleware('roles:Dispatcher');
	Route::get('getDriverNames', 'Api\DeliveryController@getDriverNames')->middleware('roles:Driver,Dispatcher');
    Route::get('getDeliveries', 'Api\DeliveryController@getDeliveries')->middleware('roles:Driver');
    Route::post('deleteDelivery', 'Api\DeliveryController@deleteDelivery')->middleware('roles:Dispatcher');
    Route::get('deliveriesAll', 'Api\DeliveryController@getAll')->middleware('roles:Dispatcher');
    Route::get('getDeliveryCounts', 'Api\DeliveryController@getDeliveryCounts')->middleware('roles:Dispatcher');
    Route::post('createDelivery', 'Api\DeliveryController@createDelivery')->middleware('roles:Dispatcher');
    Route::post('logout', 'Api\Auth\LoginController@logout');
    Route::post('setDelivered', 'Api\DeliveryController@setDelivered')->middleware('roles:Driver,Dispatcher');
    Route::post('updateLastLocation', 'Api\DriverController@updateLastLocation')->middleware('roles:Driver');
    Route::get('getLastLocations', 'Api\DriverController@getLastLocations')->middleware('roles:Dispatcher');
});