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
// Route::get('/logout', 'Auth\LoginController@logout');
//Route::get('/getLumberData', 'LumberController@getData')->name('lumber_index');
//Route::resource('lumber','LumberController');
Route::get('proof',function(){

    $orders = \App\Order::with(['contract','construction.client'])->get();    
    return $orders;
    // $area = \App\Area::find(1);
    // $area = \App\Area::with(['inventories'])->find(1);
    // print_r($area->inventories);
    // return 12;
    //return $area->inventories()->find(1)->pivot->quantity;

});
Route::get('/{any}', 'SinglePageController@index')->where('any', '.*');
// Auth::routes();
// Route::group(['middleware' => ['auth']], function () {

   

// });


