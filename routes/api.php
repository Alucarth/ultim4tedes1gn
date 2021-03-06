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
Route::get('test','ReportController@test');
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
    Route::resource('origin_type','OriginTypeController');
    Route::get('getOriginTypesData','OriginTypeController@getData');
    Route::resource('purchase','PurchaseController');
    Route::get('create_purchase_expensive','PurchaseController@createPurchaseExpensive');
    Route::get('add_item_purchase','PurchaseController@newPurchaseItem');
    Route::resource('package_transaction','PackageTransactionController');
    Route::resource('package','PackageController');
    Route::post('import_package','PackageController@importExcel');
    Route::post('save_packages','PackageController@saveExcel');
    Route::post('import_purchases','PurchaseController@importExcel');
    Route::post('save_purchases','PurchaseController@saveExcel');
    Route::post('transfer_lumber','PackageController@transfer_lumber');
    Route::resource('provider','ProviderController');
    Route::get('getProviderData','ProviderController@list');
    Route::resource('employee','EmployeeController');
    Route::get('getEmployeeData','EmployeeController@getData');
    Route::resource('position','PositionController');
    Route::resource('area','AreaController');
    Route::post('area/transfer','AreaController@transfer');
    Route::post('area/consume','AreaController@consume');
    Route::resource('employee_type','EmployeeTypeController');
    Route::resource('employee_contract_type','EmployeeContractTypeController');
    Route::get('/getInventoryData', 'StorageController@getData');
    Route::resource('/inventory','InventoryController');
    Route::resource('/inventory_type','InventoryTypeController');
    Route::resource('/family','FamilyController');
    Route::resource('/buyout','BuyoutController');
    Route::resource('report','ReportController');
    Route::resource('expenses','ExpensiveController');
    Route::post('package_transfer','PackageController@package_transfer');
    Route::resource('offer_types','OfferTypeController');
    Route::resource('client','ClientController');
    Route::resource('construction','ConstructionController');
    Route::resource('product','ProductController');
    Route::resource('order', 'OrderController');
    Route::resource('contract','ContractController');
    Route::resource('task','TaskController');
    Route::resource('status','StatusController');
    Route::resource('product_type','ProductTypeController');
    Route::resource('contract_type','ContractTypeController');
    Route::resource('work','WorkController');
    Route::get('employee_work/{emplyee_id}','WorkController@index_employee');
    Route::resource('payment', 'PaymentController');
    Route::resource('asset','AssetController');
    Route::resource('payment_type','PaymentTypeController');
    Route::resource('receipt_type','ReceiptTypeController');
    Route::resource('asset_type','AssetTypeController');


});
