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


Route::group(['prefix' => 'auth'], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/getLumberData', 'LumberController@getData')->name('lumber_index');
    Route::get('/getSpecieData', 'SpecieController@getData');
    Route::get('/getStorageData', 'StorageController@getData');
    Route::resource('lumber','LumberController');
    Route::resource('specie','SpecieController');
    Route::resource('storage','StorageController');
    Route::resource('type','TypeController');
    Route::resource('purchase','PurchaseController');
    Route::resource('provider','ProviderController');
});