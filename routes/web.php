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

Route::get('/boundary_loader', function(){
    return view('boundaries.boundaryLoader');
});

Route::get('view_boundaries', 'BoundariesController@get_data');

Route::resource('boundaries', 'BoundariesController');


Route::post('boundary/upload', 'BoundariesController@validate_load_store');


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
    return view('boundaries.comingSoon');
});

Route::get('/admin', function(){
    return view('admin_template');
});
