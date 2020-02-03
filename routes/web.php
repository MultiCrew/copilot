<?php

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

Route::group([
    'as' => 'home.'
], function() {
    Route::get('/', 'Home\HomeController@index')->name('index');
    Route::get('connect', 'Discord\DiscordController@connect')->name('connect');
});

/**
 * Flight routes
 */
Route::group([
    'as'        => 'flights.',              // routes are named 'flights.{}'
    'prefix'    => 'flights'                // route URLs are '/flights/{}'
], function() {
    Route::get('accept/{id}', 'Flights\FlightController@accept')->name('accept');
    Route::get('my-flights', 'Flights\FlightController@userFlights')->name('user-flights');
    // Route::get('search', 'Flights\FlightController@search')->name('search');

    // Route::resource('', 'Flights\FlightController');
    /**
     * TODO
     * For some unknown reason, the resource routes are not working properly
     *
     * The show action route below works fine, but the show action route invoked
     * through the resource routes doesn't. Pending further investigation.
     */
    Route::get('', 'Flights\FlightController@index')->name('index');
    Route::post('', 'Flights\FlightController@store')->name('store');
    Route::get('/{flight}', 'Flights\FlightController@show')->name('show');
    Route::get('/{flight}/edit', 'Flights\FlightController@edit')->name('edit');
    Route::put('/{flight}', 'Flights\FlightController@update')->name('update');
    Route::delete('/{flight}', 'Flights\FlightController@destroy')->name('destroy');
    /*
    Route::resource(
        '', 'Flights\FlightController'     // standard resource routes
    )->except([
        'create'
    ]);
    */
});

/**
 * Dispatch routes
 */
Route::group([
    'as'        => 'dispatch.',              // routes are named 'dispatch.{}'
    'prefix'    => 'dispatch'                // route URLs are '/dispatch/{}'
], function() {
    Route::get('plan/{flight}', 'Flights\DispatchController@create')->name('plan');
    Route::get('plan', 'Flights\DispatchController@store')->name('store');
    Route::get('review/{plan}', 'Flights\DispatchController@show')->name('review');
});

/*
 * Auth, account and profile routes
 */
Auth::routes();
Route::group([
    'as' => 'account.'
], function () {
    Route::get('/account', 'Auth\AccountController@index')->name('index');
    Route::patch('/account', 'Auth\AccountController@update')->name('update');
});

Route::get('cookie-consent', 'Home\LegalController@cookieConsent')->name('cookie-consent');
