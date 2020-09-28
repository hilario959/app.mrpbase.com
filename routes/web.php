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

Route::get('/', function () {
    return redirect('home');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('home')->group(function () {
        Route::get('/', 'HomeController@index')->name('home');

        Route::resource('client', 'ClientController');
        Route::resource('product', 'ProductController');
        Route::resource('order', 'OrderController');
        Route::resource('production', 'ProductionController');
        Route::resource('material', 'MaterialController');
        Route::group(['prefix' => '{material}/inventory', 'as' => 'inventory.'], function () {
            Route::post('/', 'InventoryController@store')->name('store');
        });

        Route::get('production/{id}/edit2', 'ProductionController@edit2');
        Route::any('production/view', 'ProductionController@view')->name('view');
    });
});

