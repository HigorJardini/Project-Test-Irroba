<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'Api\AuthController@login')->name('login');

Route::middleware(['auth:api'])->group(function () {
        Route::get('classes',  'Api\ClassesController@classes')->middleware('permission:read-classes')->name('classes');
        Route::get('users',    'Api\UsersController@users')->middleware('permission:read-users-manage')->name('users');
});


Route::fallback(function () {
        return response(['message' => 'Route Not Found'],404);
});
