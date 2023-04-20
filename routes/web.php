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

Route::get('/','\App\Http\Controllers\DataSetController@index')->name('dataset.index');

Route::get('/import','\App\Http\Controllers\DataSetController@import')->name('dataset.import');

Route::get('/success','\App\Http\Controllers\DataSetController@success')->name('dataset.success');

Route::get('/error','\App\Http\Controllers\DataSetController@error')->name('dataset.error');

