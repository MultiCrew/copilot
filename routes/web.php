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
 * Notification routes
 */

 Route::group([
     'as' => 'notifications.',
     'prefix' => 'notifications',
 ], function() {
    Route::get('/', 'Notification\NotificationController@notifications');
    Route::get('/{id}', 'Notification\NotificationController@read');
    Route::patch('/', 'Notification\NotificationController@update')->name('update');
 });

 /**
  * Search Routes
  */
 Route::group([
     'as' => 'search.',
     'prefix' => 'search',
 ], function() {
     Route::get('airport', 'Search\SearchController@airport')->name('airport');
     Route::get('aircraft', 'Search\SearchController@aircraft')->name('aircraft');
 });

/**
 * Flight routes
 */
Route::group([
    'as'        => 'flights.',              // routes are named 'flights.{}'
    'prefix'    => 'flights'                // route URLs are '/flights/{}'
], function() {
    // Route::get('search', 'Flights\FlightController@search')->name('search');
    Route::get('accept/{id}', 'Flights\FlightController@accept')->name('accept');
    Route::get('my-flights', 'Flights\FlightController@userFlights')->name('user-flights');
    Route::get('{flight}/archive', 'Flights\FlightController@archive')->name('archive');
});
Route::resource('flights', 'Flights\FlightController')->except(['create']); // standard resource routes

/**
 * Dispatch routes
 */
Route::group([
    'as'        => 'dispatch.',              // routes are named 'dispatch.{}'
    'prefix'    => 'dispatch'                // route URLs are '/dispatch/{}'
], function() {
    Route::get('', 'Flights\FlightPlanController@index')->name('index');
    Route::get('plan/{flight}', 'Flights\FlightPlanController@create')->name('create');
    Route::get('plan', 'Flights\FlightPlanController@store')->name('store');
    Route::get('{plan}', 'Flights\FlightPlanController@show')->name('show');
    Route::get('{plan}/accept', 'Flights\FlightPlanController@accept')->name('accept');
    Route::get('{plan}/reject', 'Flights\FlightPlanController@reject')->name('reject');
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
