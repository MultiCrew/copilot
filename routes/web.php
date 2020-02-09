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
    Route::get('/notifications', 'Notification\NotificationController@notifications');
    Route::get('{notification}', 'Notification\NotificationController@read');
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
    // Route::delete('/{flight}', 'Flights\FlightController@destroy')->name('destroy');
});

Route::resource(
    'flights', 'Flights\FlightController'     // standard resource routes
)->except([
    'create'
]);

/**
 * Dispatch routes
 */
Route::group([
    'as'        => 'dispatch.',              // routes are named 'dispatch.{}'
    'prefix'    => 'dispatch'                // route URLs are '/dispatch/{}'
], function() {
    Route::get('plan/{flight}', 'Flights\FlightPlanController@create')->name('plan');
    Route::get('plan', 'Flights\FlightPlanController@store')->name('store');
    Route::get('review/{plan}', 'Flights\FlightPlanController@show')->name('review');
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
