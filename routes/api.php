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

Route::post('login', 'AuthController@login');

Route::group(['prefix' => 'auth','middleware' => 'jwt.auth'], function ($router) {

   
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
    Route::resource('unit','UnitController');
    Route::resource('state','StateController');
    Route::resource('purchase','PurchaseController');
    Route::resource('package_transaction','PackageTransactionController');
    Route::resource('package','PackageController');    
    Route::post('import_package','PackageController@importExcel');    
    Route::post('save_packages','PackageController@saveExcel');    
    Route::post('import_purchases','PurchaseController@importExcel');    
    Route::post('save_purchases','PurchaseController@saveExcel');    
    Route::resource('provider','ProviderController');
    Route::get('getProviderData','ProviderController@list');
    Route::resource('employee','EmployeeController');
    Route::resource('position','PositionController');
    Route::resource('area','AreaController');
    Route::resource('employee_type','EmployeeTypeController');
    Route::resource('employee_contract_type','EmployeeContractTypeController');
    Route::get('/getInventoryData', 'StorageController@getData');
    Route::resource('/getInventory','InventoryController');
});