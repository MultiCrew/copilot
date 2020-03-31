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
    Route::get('/notifications/{id}', 'Notification\NotificationController@read');
});

/**
 * Flight routes
 *
 * These routes deal with the Flight and ArchivedFlight model resources
 * All users interact with these controllers as part of their Copilot workflot
 */
Route::group([
    'as'        => 'flights.',              // routes are named 'flights.{}'
    'prefix'    => 'flights'                // route URLs are '/flights/{}'
], function() {
    // Route::get('search', 'Flights\FlightController@search')->name('search');
    Route::get('accept/{id}', 'Flights\FlightController@accept')->name('accept');
    Route::get('my-flights', 'Flights\FlightController@userFlights')->name('user-flights');
    Route::post('{flight}/archive', 'Flights\ArchivedFlightController@store')->name('archive');
});
Route::resource('flights', 'Flights\FlightController')->except(['create']); // standard resource routes
Route::resource('archive', 'Flights\ArchivedFlightController')->only(['index', 'show', 'store']);

/**
 * Dispatch routes
 *
 * These routes deal with the SimBrief API integration: creation and reviewing
 * of Flight plans (FlightPlan models).
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
 *
 * These routes deal with authentication, user accounts, user management, application
 * forms and user profiles
 */
Auth::routes();
Route::group([
    'as'        => 'account.',
    'prefix'    => 'account'
], function () {
    Route::get('/apply', 'Auth\Application\ApplicationController@create')->name('apply');
    Route::post('/apply'. 'Auth\Application\ApplicationController@store')->name('store');
});
Route::resource('account', 'Auth\AccountController')->only(['index', 'update']);

Route::resource('profile', 'Auth\ProfileController');

Route::group([
    'as'        => 'admin.',
    'prefix'    => 'admin'
], function () {
    Route::resource('users', 'Auth\Admin\UserController');
    Route::resource('applications', 'Auth\Application\ApplicationAdminController')
         ->except(['create', 'store']);
});

Route::get('cookie-consent', 'Home\LegalController@cookieConsent')->name('cookie-consent');
