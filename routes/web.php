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

Auth::routes();

Route::prefix('{tahun?}')->middleware('bindTahun')->group(function(){
	Route::get('/admin','AdminCtrl@index')->name('admin.index');
	Route::get('/', 'HomeCtrl@index')->name('index');

	Route::get('/query-data', 'DataCTRL@index')->name('query.data');
	Route::get('/query-data-category/{id_category}/{slug}', 'DataCtrl@categorical')->name('query.data.categorycal');


	Route::get('/data/{id}/{slug}', 'DataCtrl@detail')->name('query.data.detail');


});


