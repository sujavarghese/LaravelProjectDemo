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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/unknown', function () {
    return view('errorpage');
});

Route::get('/boundary_loader', 'BoundariesController@view_loader');

Route::get('view_boundaries', 'BoundariesController@get_data');

Route::resource('boundaries', 'BoundariesController');

Route::get('boundary/export_mapinfo', 'BoundariesController@export_mapinfo');

Route::get('boundary/export_kml', 'BoundariesController@export_kml');

Route::get('boundary/convert_kml_to_mapinfo', 'BoundariesController@convert_kml_to_mapinfo');

Route::post('boundary/upload', 'BoundariesController@validate_load_store');

Route::get('boundary/sam_names', 'BoundariesController@get_sam_names');

Route::get('boundary/sam_types', 'BoundariesController@get_boundary_types');

Route::get('/mapinfo_validator', function(){
    return view('mapinfoValidator');
});

Route::get('/new_menu', function(){
    return view('newHome');
});

Route::get('/kml_export', function(){
    return view('boundaries.comingSoon');
});

Route::get('/map', function(){
    return view('map.mapViewer');
});

Route::get('/admin', function(){
    return view('admin_template');
});
