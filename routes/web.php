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

Route::get('/', function () {        
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
    Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
    // list all lfm routes here...
});

Route::get('/dashboard', 'DashboardController@index');
// CRUD Reporters
Route::get('/reporters/create', 'ReporterController@create');
Route::post('/reporters/create', 'ReporterController@save');
Route::get('/reporters', 'ReporterController@read');
Route::get('/reporters/{reporter}', 'ReporterController@view');
Route::get('/reporters/edit/{reporter}', 'ReporterController@edit');
Route::post('/reporters/update/{reporter}', 'ReporterController@update');
Route::post('/reporters/delete/{reporter}', 'ReporterController@delete');
// CRUD Drivers
Route::get('/drivers/create', 'DriverController@create');
Route::post('/drivers/create', 'DriverController@save');
Route::get('/drivers', 'DriverController@read');
Route::get('/drivers/{driver}', 'DriverController@view');
Route::get('/drivers/edit/{driver}', 'DriverController@edit');
Route::post('/drivers/update/{driver}', 'DriverController@update');
Route::post('/drivers/delete/{driver}', 'DriverController@delete');
// CRUD Incidents
Route::get('/incidents/create', 'IncidentController@create');
Route::post('/incidents/create', 'IncidentController@save');
Route::get('/incidents', 'IncidentController@read');
Route::get('/incidents/{incident}', 'IncidentController@view');
Route::get('/incidents/edit/{incident}', 'IncidentController@edit');
Route::post('/incidents/update/{incident}', 'IncidentController@update');
Route::post('/incidents/delete/{incident}', 'IncidentController@delete');
