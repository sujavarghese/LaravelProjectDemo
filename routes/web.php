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
    return view('errorpage');
});

Route::get('boundaries/boundary_loader', 'BoundariesController@index');

Route::get('boundaries/view_boundaries', 'BoundariesController@store');

Route::post('boundaries/upload', 'BoundariesController@create');

Route::resource('boundaries', 'BoundariesController');

Route::get('export/export_mapinfo', 'DataExportController@export_mapinfo');

Route::get('export/export_kml', 'DataExportController@export_kml');

Route::get('export/convert_kml_to_mapinfo', 'DataExportController@convert_kml_to_mapinfo');


Route::get('/mapinfo_validator', function () {
    return view('mapinfoValidator');
});

Route::get('/new_menu', function () {
    return view('newHome');
});

Route::get('/kml_export', function () {
    return view('boundaries.comingSoon');
});

Route::get('/map', 'MapController@index');

Route::get('/admin', function () {
    return view('admin_template');
});
