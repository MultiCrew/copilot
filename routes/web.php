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
    Route::get('/', 'Home\HomeController@index')->name('home');
    Route::get('dashboard', 'Home\HomeController@dashboard')->name('dashboard');
    Route::get('connect', 'Discord\DiscordController@connect')->name('connect');
});

Route::group([
	'as' => 'flights.'
], function() {
	Route::get('dashboard', 'Flights\SearchController@index')->name('dashboard');
	Route::get('search', 'Flights\SearchController@search')->name('search');
});

Auth::routes();
Route::get('account', 'Auth\AccountController@index')->name('account');
Route::get('profile', 'Auth\ProfileController@index')->name('profile');

Route::get('cookie-consent', 'Home\LegalController@cookieConsent')->name('cookie-consent');
