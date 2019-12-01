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
});

Auth::routes();

Route::get('cookie-consent', 'Home\LegalController@cookieConsent')->name('cookie-consent');
