<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'Web\Login\LoginController@index')->name('index');

Route::namespace('Web\Login')->prefix('login')->name('login')->group(function () {
    Route::get('',                            'LoginController@index')->name('.index');
    Route::get('logout',                      'LoginController@logout')->name('.logout');
    Route::post('access',                     'LoginController@access')->name('.access');
});

Route::namespace('Web\Login')->prefix('register')->name('register')->group(function () {
    Route::get('',                            'RegisterController@index')->name('.index');
});

Route::namespace('Web\Admin')->prefix('admin')->name('admin')->middleware('auth')->group(function () {
    Route::get('',                            'DashboardController@index')->name('.dashboard');
});