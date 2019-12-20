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
    Route::get('connect', 'Discord\DiscordController@connect')->name('connect');
});

Route::group([
    'as' => 'flights.',
    'prefix' => 'flights'
], function() {
    Route::resources([
        '/' => 'Flights\FlightController'
    ]);
    Route::get('search', 'Flights\FlightController@search')->name('search');

    Route::get('accept/{id}', 'Flights\FlightController@accept')->name('accept');
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

Route::resource('profile', 'Auth\ProfileController')->only([
    'index', 'update'
]);

Route::get('cookie-consent', 'Home\LegalController@cookieConsent')->name('cookie-consent');
