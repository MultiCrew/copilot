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
//     return $request->user();
// });

Route::middleware('client')->group(function() {
    // Route::get('/test', function (Request $request) {
    //     return 'test';
    // });
    Route::get('/search', 'API\FlightController@search');
    Route::post('/create', 'API\FlightController@store');
    //add all API requests for the discord bot here
});
