<?php

use App\Http\Controllers\TireController;
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

Route::get('/', 'TireController@index');
Route::resource('tires', 'TireController')->except('show');
Route::resource('manufacturers', 'ManufacturerController')->except('show');
Route::resource('tire-models', 'TireModelController')->except('show');
Route::post('tires/upload_from_file', 'TireController@uploadFromFile')->name('tires.upload.from.file');
Route::get('tires/get-progress', 'TireController@getProgress')->name('tires.get.progress');
