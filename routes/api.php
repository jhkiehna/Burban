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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return Auth::user();
});

Route::prefix('/deals')->group(function() {
    Route::get('/', 'DealController@index');
    Route::get('/{deal}', 'DealController@show');

    Route::middleware('auth:api')->post('/', 'DealController@store');
    Route::middleware('auth:api')->patch('/{deal}', 'DealController@update');
});

Route::prefix('/businesses')->group(function() {
    Route::get('/{business}', 'BusinessController@show');
    Route::get('/{business}/deals', 'BusinessDealController@index');
});
