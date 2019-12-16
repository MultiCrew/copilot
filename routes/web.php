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
    Route::get('connect', 'Discord\DiscordController@connect')->name('connect');
});

/*
 * Auth, account and profile routes
 */
Auth::routes();
Route::resource('account', 'Auth\AccountController')->only([
    'index', 'update'
]);
Route::resource('profile', 'Auth\ProfileController')->only([
    'index', 'update'
]);

Route::get('cookie-consent', 'Home\LegalController@cookieConsent')->name('cookie-consent');
