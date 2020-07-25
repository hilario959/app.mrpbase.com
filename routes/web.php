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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/home/client', 'ClientController');
Route::resource('/home/product', 'ProductController');
Route::resource('/home/order', 'OrderController');
Route::resource('/home/production', 'ProductionController');
Route::any('/home/production/view', 'ProductionController@view')->name('view');