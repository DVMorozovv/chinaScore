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
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\ImageSearchController;
use App\Http\Controllers\CreateSearchImageController;
use App\Http\Controllers\ArticleController;


// Admin Controllers

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SupportCrudController;
use App\Http\Controllers\Admin\TariffCrudController;
use App\Http\Controllers\Admin\UserCrudController;
use App\Http\Controllers\Admin\ArticleCrudController;

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

Route::get('/cat', function () {
    return view('/pages/cat');
});

Route::get('/items', function () {
    return view('pages/items');
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/categories', [CategoryController::class, 'categories'])->name('categories');
    Route::post('/search/{id}', [CategoryController::class, 'SearchItems_ByName'])->name('search_form');
    Route::get('/categories/{id}', [CategoryController::class, 'categories_child'])->name('categories_child');
    Route::get('/items/{id}', [CategoryController::class, 'SearchItems_ByCategory'])->name('get_item_by_cat');
    Route::get('/create/{id}', [CreateFileController::class, 'create_table'])->name('create');
    Route::post('/items/search/{id}', [CategoryController::class, 'SearchItems_ByName'])->name('search_cat_form');
    Route::get('/search-title', [SearchTitleController::class, 'SearchTitle'])->name('search-title');

    Route::get('/search-photo', function () {return view('pages/search-photo');})->name('search-photo');
    Route::post('/search-result', [ImageSearchController::class, 'imageSearch'])->name('searchPhotoForm');
    Route::get('/dwnld', [CreateSearchImageController::class, 'create_excel'])->name('create-img');


    Route::get('/learning', [ArticleController::class, 'index'])->name('learning');
    Route::get('/learning/{id}', [ArticleController::class, 'article'])->name('article');


    Route::get('/referral', [ReferralController::class, 'refer'])->name('referral');

    Route::get('/profile-settings', function () {return view('pages/profile-settings');})->name('profile-settings');
    Route::post('/profile-settings/RedactProfileForm', [EditProfileController::class, 'RedactProfileForm'])->name('RedactProfileForm');
    Route::put('/edit_profile/updateUserPassword', [EditProfileController::class, 'updateUserPassword'])->name('updateUserPassword');

    Route::get('/user-files', [ShowFileController::class, 'files'])->name('user-files');
    Route::get('/user-files/download', [ShowFileController::class, 'download_file'])->name('download_file');

    Route::get('/support', function () {return view('pages/support');})->name('support');
    Route::post('/support/send', [SupportController::class, 'SupportForm'])->name('contactForm');

});


Route::group(['middleware' => ['role:admin', 'auth'], 'prefix' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::resource('tariffs', TariffCrudController::class);
    Route::resource('user', UserCrudController::class);
    Route::resource('support', SupportCrudController::class);
    Route::resource('articles', ArticleCrudController::class);

});
