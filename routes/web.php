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
    Route::get('', 'Home\HomeController@index')->name('home');
    Route::get('connect', 'Discord\DiscordController@connect')->name('connect');
});

Route::resources([
    'flights' => 'Flights\FlightController'
]);
Route::get('search', 'Flights\FlightController@search')->name('flights.search');

Auth::routes();
Route::get('account', 'Auth\AccountController@index')->name('account');
Route::get('profile', 'Auth\ProfileController@index')->name('profile');

Route::get('cookie-consent', 'Home\LegalController@cookieConsent')->name('cookie-consent');
