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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return Auth::user();
// });

Route::prefix('/deals')->group(function() {
    Route::get('/', 'DealController@index');
    Route::get('/{deal}', 'DealController@show');
    Route::middleware('auth:api')->post('/', 'DealController@store');
    Route::middleware('auth:api')->patch('/{deal}', 'DealController@update');
    
    Route::middleware('auth:api')->get('/saved', 'SavedDealController@index');
    Route::middleware('auth:api')->post('/saved', 'SavedDealController@store');
    Route::middleware('auth:api')->delete('/saved/{dealId}', 'SavedDealController@destroy');
});

Route::prefix('/businesses')->group(function() {
    Route::get('/{business}', 'BusinessController@show');
    Route::middleware('auth:api')->post('/', 'BusinessController@store');
    Route::middleware('auth:api')->patch('/{business}', 'BusinessController@update');
    Route::middleware('auth:api')->delete('/{business}', 'BusinessController@destroy');

    Route::get('/{business}/deals', 'BusinessDealController@index');
});

Route::prefix('/user')->group(function() {
    Route::post('/login', 'LoginController@login');
    Route::post('/register', 'RegistrationController@register');
    
    Route::middleware('auth:api')->get('/logout', 'LoginController@logout');
});
