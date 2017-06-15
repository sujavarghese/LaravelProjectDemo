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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index');

Route::get('/unknown', function () {
    return view('errors/404');
});

Route::get('/boundaries/boundary_loader', 'BoundariesController@index');

Route::get('/boundaries/view_boundaries', 'BoundariesController@store');

Route::post('boundaries/upload', 'BoundariesController@create');

Route::post('boundaries/get_coordinates', 'BoundariesController@get_coordinates');

Route::get('/boundaries/get_sam_names', 'BoundariesController@get_sam_names');

Route::resource('/boundaries', 'BoundariesController');

Route::get('/export', 'DataExportController@index');

Route::get('/export/kml/{type}/{code}/{job_code?}', 'DataExportController@export_kml');

Route::get('/export/convert_kml_to_mapinfo', 'DataExportController@convert_kml_to_mapinfo');

Route::get('/user_activity_log', 'HomeController@get_user_activity_log');

Route::get('/kml_sample_template', 'BoundariesController@download_kml_sample');

Route::get('/map', 'MapController@index');

Route::get('/admin', function () {
    return view('admin_template');
});
