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
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/unknown', function () {
    return view('errorpage');
});

Route::get('/boundary_loader', function(){
    return view('boundaries.boundaryLoader');
});
//Route::get('/view_boundaries', function(){
//    $boundaries = Boundaries::all();
//    return View::make("boundaries.viewBoundaries")->with("allBoundaries", $boundaries);
////    return view('boundaries.viewBoundaries');
//});
Route::get('view_boundaries', 'BoundariesController@get_data');

Route::resource('boundaries', 'BoundariesController');

//Route::resource('boundaries', 'BoundariesController');

//
//Route::post('boundary/upload', function() {
//    return view('BoundariesController@validate_load_store');
//});

Route::post('boundary/upload', 'BoundariesController@validate_load_store');


Route::get('/mapinfo_validator', function(){
    return view('mapinfoValidator');
});

Route::get('/new_menu', function(){
    return view('newHome');
});

Route::get('/test', function(){
    return view('testpage');
});

Route::get('/admin', function(){
    return view('admin_template');
});
//Route::get('upload', function() {
//    return View::make('upload');
//});

//Route::post('apply/upload', 'ApplyController@upload_new');

//Route::post('boundary_loader_new', 'BoundariesController');
//Route::post('boundary_loader_new', function(Request $r){
//    echo "EWhat";
//    echo $r;
//    echo $r->get('selBoundaryName');
////    return ['as' => 'validate_store',
////        'uses' => 'BoundariesController@validate_store']  ;
//});
//echo "Hello";



//Route::get('boundary_loader_new', function() {
//    return View::make('pages.upload');
//});
//Route::get('boundary_loader_new', function(){
//    echo 'Hello';
//    return  view('boundaries.boundaryLoader');
//});
//
//Route::post('boundary_loader_new', 'BoundariesController@validate_store');



//
//Menu::registerDefault([
//    Menu::link('home.index', 'Landing Page'),
//    Menu::link('home.news', 'News'),
//    Menu::link('home.about', 'About'),
//    Menu::dropdown([
//        Menu::link('content.users', 'Users'),
//        Menu::link('content.articles', 'Articles'),
//        Menu::dropdownDivider(),
//        Menu::dropdownHeader('More Content'),
//        Menu::link('content.blog', 'Blog')
//    ], 'Content')
//], ['class' => 'nav navbar-nav']);
//
//Menu::register('navbar-right', [
//    Menu::link('auth.login', 'Login'),
//    Menu::link('auth.register', 'Register')
//], ['class' => 'nav navbar-nav navbar-right']);

Route::group(['middleware' => ['web']], function () {
    Route::get('/index', function() {
        return view('home.index'); // TODO
    })->name('home.index');

    Route::get('/news', function() {
        return view('home.index'); // TODO
    })->name('home.news');

    Route::get('/about', function() {
        return view('home.index'); // TODO
    })->name('home.about');

    Route::get('/content/users', function() {
        return view('home.index'); // TODO
    })->name('content.users');

    Route::get('/content/articles', function() {
        return view('home.index'); // TODO
    })->name('content.articles');

    Route::get('/content/articles/{id}', function($id) {
        return view('home.index'); // TODO
    })->name('content.show_article');

    Route::get('/auth/login', function() {
        return view('home.index'); // TODO
    })->name('auth.login');

    Route::get('/auth/register', function() {
        return view('home.index'); // TODO
    })->name('auth.register');
});

