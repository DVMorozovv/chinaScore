<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// User Controllers

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CreateFileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\SearchTitleController;
use App\Http\Controllers\ShowFileController;
use App\Http\Controllers\EditProfileController;





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
    return view('/pages/home');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');

// 1688 routes

Route::get('/cat', function () {
    return view('/pages/cat');
});

Route::get('/items', function () {
    return view('pages/items');
});

Route::get('/categories', [CategoryController::class, 'categories'])->middleware('auth')->name('categories');

Route::post('/search/{id}', [CategoryController::class, 'SearchItems_ByName'])->middleware('auth')->name('search_form');

Route::get('/categories/{id}', [CategoryController::class, 'categories_child'])->middleware('auth')->name('categories_child');

Route::get('/items/{id}', [CategoryController::class, 'SearchItems_ByCategory'])->middleware('auth')->name('get_item_by_cat');

Route::get('/create/{id}', [CreateFileController::class, 'create_table'])->middleware('auth')->name('create');

Route::post('/items/search/{id}', [CategoryController::class, 'SearchItems_ByName'])->middleware('auth')->name('search_cat_form');

Route::get('/search-title', [SearchTitleController::class, 'SearchTitle'])->middleware('auth')->name('search-title');

Route::get('/search-photo', function ()
    {return view('pages/search-photo');
})->middleware('auth')->name('search-photo');

Route::get('/profile-settings', function ()
    {return view('pages/profile-settings');
})->middleware('auth')->name('profile-settings');

Route::post('/profile-settings/edit', [EditProfileController::class, 'RedactProfileForm'])->middleware('auth')->name('RedactProfileForm');

Route::get('/user-files', [ShowFileController::class, 'files'])->middleware('auth')->name('user-files');

Route::get('/user-files/download',  [ShowFileController::class, 'download_file'])->middleware('auth')->name('download_file');

Route::get('/support', function () {return view('pages/support');})->name('support');

Route::post('/support/send', [SupportController::class, 'SupportForm'])->name('contactForm');


