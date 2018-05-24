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

Route::get('/', 'OrderController@register')->name('user-registration');

Route::get('user-registration', 'OrderController@register')->name('user-registration');
Route::post('payment', 'OrderController@order');
Route::get('terms-conditions', 'OrderController@termsConditions');

Route::prefix('manage')->group(function () {
  Route::get('login', 'UsersController@login');
  Route::post('login', 'UsersController@processLogin');
  Route::get('logout', 'UsersController@logout');
  Route::group(['middleware' => 'adminAuthenticate'], function ($url) {
    Route::get('/', 'UsersController@index');
    Route::get('users', 'UsersController@index');
  });
});
