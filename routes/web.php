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
    Route::get('/policies', 'Home\HomeController@policy')->name('policy');
    Route::get('connect', 'Discord\DiscordController@connect')->name('connect')->middleware('verified');
    Route::get('disconnect', 'Discord\DiscordController@disconnect')->name('disconnect')->middleware('verified');
});

/**
 * Notification routes
 */

 Route::group([
     'as' => 'notifications.',
     'prefix' => 'notifications',
     'middleware' => 'verified'
 ], function() {
    Route::get('/', 'Notification\NotificationController@notifications');
    Route::get('/mark-all-read', 'Notification\NotificationController@markAllRead');
    Route::get('/{id}', 'Notification\NotificationController@read');
    Route::post('/update', 'Notification\NotificationController@update')->name('update');
    Route::post('/airport', 'Notification\NotificationController@airport')->name('airport');
    Route::post('/aircraft', 'Notification\NotificationController@aircraft')->name('aircraft');
 });

 /**
  * Search Routes
  */
 Route::group([
     'as' => 'search.',
     'prefix' => 'search',
     'middleware' => 'verified'
 ], function() {
     Route::get('airport', 'Search\SearchController@airport')->name('airport');
     Route::get('aircraft', 'Search\SearchController@aircraft')->name('aircraft');
 });

/**
 * FlightRequest routes
 *
 * These routes deal with the FlightRequest and ArchivedFlight model resources
 * All users interact with these controllers as part of their Copilot workflot
 */
Route::group([
    'as'         => 'flights.',              // routes are named 'flights.{}'
    'prefix'     => 'flights',               // route URLs are '/flights/{}'
    'middleware' => 'verified'
], function() {
    // Route::get('search', 'Flights\FlightController@search')->name('search');
    Route::get('accept/{id}', 'Flights\FlightController@acceptPublic')->name('accept');
    Route::get('accept/private/{code}', 'Flights\FlightController@acceptPrivate')->name('accept.private');
    Route::get('my-flights', 'Flights\FlightController@userFlights')->name('user-flights');
    Route::post('{flight}/archive', 'Flights\ArchivedFlightController@store')->name('archive');
    Route::get('/archive/{flight}', 'Flights\ArchivedFlightController@show')->name('archive.show');
});
Route::group(['middleware' => ['verified']], function () {
    Route::resource('flights', 'Flights\FlightController')->except(['create']); // standard resource routes
    Route::resource('archive', 'Flights\ArchivedFlightController')->only(['index', 'show', 'store']);
    Route::resource('aircraft', 'Aircraft\ApprovedAircraftController')->only(['index', 'store']);
    Route::resource('aircraft', 'Aircraft\ApprovedAircraftAdminController')->except(['index', 'edit', 'store']);
});

/**
 * Dispatch routes
 *
 * These routes deal with the SimBrief API integration: creation and reviewing
 * of FlightRequest plans (FlightPlan models).
 */
Route::group([
    'as'         => 'dispatch.',              // routes are named 'dispatch.{}'
    'prefix'     => 'dispatch',               // route URLs are '/dispatch/{}'
    'middleware' => 'verified'
], function() {
    Route::get('', 'Flights\FlightPlanController@index')->name('index');
    Route::get('plan/{flight}', 'Flights\FlightPlanController@create')->name('create');
    Route::get('plan/{flight}/upload', 'Flights\FlightPlanController@upload')->name('upload');
    Route::get('plan', 'Flights\FlightPlanController@store')->name('store');
    Route::post('plan/upload', 'Flights\FlightPlanController@store')->name('store.upload');
    Route::get('{plan}', 'Flights\FlightPlanController@show')->name('show');
    Route::get('{plan}/accept', 'Flights\FlightPlanController@accept')->name('accept');
    Route::get('{plan}/reject', 'Flights\FlightPlanController@reject')->name('reject');
});

/*
 * Auth, account and profile routes
 *
 * These routes deal with authentication, user accounts, user management, application
 * forms and user profiles
 */
Auth::routes(['verify' => true]);
Route::resource('apply', 'Auth\Application\ApplicationController')->only(['create', 'store'])->middleware('verified');
Route::group([
    'as' => 'account.',
    'prefix' => 'account',
    'middleware' => 'verified',
], function () {
    Route::get('/', 'Auth\AccountController@index')->name('index');
    Route::patch('/update', 'Auth\AccountController@update')->name('update');
});

Route::resource('profile', 'Auth\ProfileController')->middleware('verified');

// administration routes
Route::group([
    'as'        => 'admin.',
    'prefix'    => 'admin',
    'middleware' => 'verified'
], function () {
    Route::resource('users', 'Auth\Admin\UserController');
    Route::resource('applications', 'Auth\Application\ApplicationAdminController')
         ->except(['create', 'store']);
});

// cookie message route
Route::get('cookie-consent', 'Home\LegalController@cookieConsent')->name('cookie-consent');
