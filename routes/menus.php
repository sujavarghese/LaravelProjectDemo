<?php

Menu::registerDefault([
    Menu::link('home.index', 'Landing Page'),
    Menu::link('home.news', 'News'),
    Menu::link('home.about', 'About'),
    Menu::dropdown([
        Menu::link('content.users', 'Users'),
        Menu::link('content.articles', 'Articles'),
        Menu::dropdownDivider(),
        Menu::dropdownHeader('More Content'),
        Menu::link('content.blog', 'Blog')
    ], 'Content')
], ['class' => 'nav navbar-nav']);

Menu::register('navbar-right', [
    Menu::link('auth.login', 'Login'),
    Menu::link('auth.register', 'Register')
], ['class' => 'nav navbar-nav navbar-right']);

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

