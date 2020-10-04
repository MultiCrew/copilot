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
    Route::get('/aircraft', 'API\FlightController@aircraft');
    Route::post('/create', 'API\FlightController@store');
    Route::post('/accept', 'API\FlightController@accept');
    //add all API requests for the discord bot here
});

Route::middleware(['auth:api', 'public'])->group(function() {
    // All API routes here
});
