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

Route::prefix('/deals')->group(function() {
    Route::middleware(['auth:api', 'verified'])->get('/saved', 'SavedDealController@index');
    Route::middleware(['auth:api', 'verified'])->post('/saved', 'SavedDealController@store');
    Route::middleware(['auth:api', 'verified'])->delete('/saved/{dealId}', 'SavedDealController@destroy');

    Route::get('/', 'DealController@index');
    Route::get('/{deal}', 'DealController@show');
    Route::middleware(['auth:api', 'verified'])->post('/', 'DealController@store');
    Route::middleware(['auth:api', 'verified'])->patch('/{deal}', 'DealController@update');
    Route::middleware(['auth:api', 'verified'])->delete('/{deal}', 'DealController@destroy');
});

Route::prefix('/businesses')->group(function() {
    Route::get('/{business}', 'BusinessController@show');
    Route::middleware(['auth:api', 'verified'])->post('/', 'BusinessController@store');
    Route::middleware(['auth:api', 'verified'])->patch('/{business}', 'BusinessController@update');
    Route::middleware(['auth:api', 'verified'])->delete('/{business}', 'BusinessController@destroy');

    Route::get('/{business}/deals', 'BusinessDealController@index');
});

Route::prefix('/user')->group(function() {
    Route::post('/login', 'LoginController@login');
    Route::post('/register', 'RegistrationController@register');
    
    Route::middleware(['auth:api', 'verified'])->get('/logout', 'LoginController@logout');
    Route::middleware(['auth:api', 'verified'])->delete('/delete', 'UserController@destroy');
    Route::middleware(['auth:api', 'verified'])->patch('/updatePassword', 'UserController@updatePassword');
    Route::middleware(['auth:api', 'verified'])->patch('/updateEmail', 'UserController@updateEmail');

    Route::middleware('auth:api')->get('/verify-email', 'EmailVerificationController@index');
    // Route::get('/verify-email', 'EmailVerificationController@index');
});
