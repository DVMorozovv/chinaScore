<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
//use App\Http\Controllers\LanguageController;

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

//Auth::routes(['verify' => true]);
//
//Route::get('/test', function () {
//    return view('pages/test');
//});
//
//Route::get('/', [DashboardController::class, 'dashboardModern']);
//
//Route::get('lang/{locale}', [LanguageController::class, 'swap']);


//1688

Route::get('/test', function () {
    return view('pages/test');
});

Route::get('/', function () {
    return view('/pages/home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');

// 1688 routes

Route::get('/cat', function () {
    return view('/pages/cat');
});

Route::get('/items', function () {
    return view('pages/items');
});

Route::get('/categories', 'App\Http\Controllers\CategoryController@categories')->middleware('auth')->name('categories');

Route::get('/search/{id}', 'App\Http\Controllers\CategoryController@SearchItems_ByName')->middleware('auth')->name('search_form');

Route::get('/categories/{id}', 'App\Http\Controllers\CategoryController@categories_child')->middleware('auth')->name('categories_child');

Route::get('/items/{id}', 'App\Http\Controllers\CategoryController@SearchItems_ByCategory')->middleware('auth')->name('get_item_by_cat');

Route::get('/create/{id}', 'App\Http\Controllers\FileController@create_table')->middleware('auth')->name('create');

Route::get('/items/search/{id}', 'App\Http\Controllers\CategoryController@SearchItems_ByName')->middleware('auth')->name('search_cat_form');

Route::get('/search-title', 'App\Http\Controllers\SearchTitleController@SearchTitle')->middleware('auth')->name('search-title');

Route::get('/search-photo', function () {return view('pages/search-photo');})->middleware('auth')->name('search-photo');

Route::get('/profile-settings', function () {return view('pages/profile-settings');})->middleware('auth')->name('profile-settings');

Route::get('/user-files', 'App\Http\Controllers\ProfileController@files')->middleware('auth')->name('user-files');

Route::get('/user-files/d', 'App\Http\Controllers\FileController@download_file')->middleware('auth')->name('download_file');

Route::get('/support', function () {return view('pages/support');})->name('support');
Route::get('/support/d', 'App\Http\Controllers\ContactController@ContactForm')->name('contactForm');
