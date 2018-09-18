<?php

use Illuminate\Http\Request;

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
Route::resource('provider','ProviderController');
Route::post('/getProviderData','ProviderController@getData');

Route::group(['prefix' => 'auth'], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/getLumberData', 'LumberController@getData')->name('lumber_index');
    Route::resource('lumber','LumberController');
    Route::resource('specie','SpecieController');
    Route::resource('type','TypeController');
});