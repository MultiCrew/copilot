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

Route::middleware('client', 'bot')->group(function() {
    Route::get('/search', 'API\Discord\FlightController@search');
    Route::get('/aircraft', 'API\Discord\FlightController@aircraft');
    Route::post('/create', 'API\Discord\FlightController@store');
    Route::post('/accept', 'API\Discord\FlightController@accept');
    //add all API requests for the discord bot here
});

Route::group([
    'middleware' => ['auth:api'],
    'prefix' => 'v1',
    'namespace' => 'API\v1'
], function () {
    Route::group(['namespace' => 'Flights'], function () {
        Route::apiResource('requests', 'RequestController');
        Route::get('requests/{request}/accept/{code?}')->uses('RequestController@accept');
    });
    // API Routes here
});
