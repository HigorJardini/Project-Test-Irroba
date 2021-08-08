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
    Route::get('',                                  'LoginController@index')->name('.index');
    Route::get('logout',                            'LoginController@logout')->name('.logout');
    Route::post('access',                           'LoginController@access')->name('.access');
});

Route::namespace('Web\Login')->prefix('register')->name('register')->group(function () {
    Route::get('',                                  'RegisterController@index')->name('.index');
    Route::post('create',                           'RegisterController@create')->name('.create');
});

Route::namespace('Web\Admin')->prefix('admin')->name('admin')->middleware('auth', 'logout.user')->group(function () {

    Route::get('',                                  'DashboardController@index')->name('.dashboard');

    Route::namespace('Users')->prefix('users')->name('.users')->middleware('permission:read-users')->group(function () {
        Route::get('aproved',                       'UsersController@index')->name('.aproved.index');
        Route::put('aproved/{user_id}',             'UsersController@accept')->middleware('permission:update-users-aproved')->name('.aproved.accept');

        Route::prefix('manage')->name('.manage')->middleware('permission:read-users-manage')->group(function () {
            Route::get('',                          'UsersController@manageIndex')->name('.index');
            Route::get('create',                    'UsersController@manageCreate')->middleware('permission:create-users-manage')->name('.create');
            Route::post('store',                    'UsersController@manageStore')->middleware('permission:create-users-manage')->name('.create.store');
            Route::get('view/{user_id}',            'UsersController@manageView')->middleware('permission:update-users-manage')->name('.view');
            Route::put('update/{user_id}',          'UsersController@manageUpdate')->middleware('permission:update-users-manage')->name('.update');
        });

        Route::delete('delete/{user_id}',           'UsersController@delete')->middleware('permission:delete-users')->name('.delete.users');

    });

    Route::namespace('Metters')->prefix('metters')->middleware('permission:read-metters')->name('.metters')->group(function () {
        Route::get('',                              'MettersController@index')->name('.index');
        Route::get('create',                        'MettersController@create')->middleware('permission:create-metters')->name('.create');
        Route::post('store',                        'MettersController@store')->middleware('permission:create-metters')->name('.create.store');
        Route::get('view/{metter_id}',              'MettersController@view')->middleware('permission:update-metters')->name('.view');
        Route::put('update/{metter_id}',            'MettersController@update')->middleware('permission:update-metters')->name('.update');
        Route::delete('delete/{metter_id}',         'MettersController@delete')->middleware('permission:delete-users')->name('.delete');
    });

    Route::namespace('Classes')->prefix('classes')->middleware('permission:read-classes')->name('.classes')->group(function () {
        Route::get('',                              'ClassesController@index')->name('.index');
        Route::get('create',                        'ClassesController@create')->middleware('permission:create-classes')->name('.create');
        Route::post('store',                        'ClassesController@store')->middleware('permission:create-classes')->name('.create.store');
        Route::get('view/{classe_id}',              'ClassesController@view')->middleware('permission:update-classes')->name('.view');
        Route::put('update/{classe_id}',            'ClassesController@update')->middleware('permission:update-classes')->name('.update');
        Route::delete('delete/{classe_id}',         'ClassesController@delete')->middleware('permission:delete-classes')->name('.delete');

        Route::get('request/{classe_id}',           'ClassesController@request')->middleware('permission:request-classes')->name('.request');
        Route::delete('request/cancel/{classe_id}', 'ClassesController@requestCancel')->middleware('permission:request-cancel-classes')->name('.request.cancel');
    });

});