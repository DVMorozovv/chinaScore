<?php


use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SearchItemsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// User Controllers

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CreateFileController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\SearchTitleController;
use App\Http\Controllers\ShowFileController;
use App\Http\Controllers\EditProfileController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\CreateSearchImageController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TariffController;


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
    return view('/pages/lending');
});

Route::get('/login', function () {
    return view('pages/login');
})->name('login');

Route::get('/policy', function () {
    return view('pages/policy');
})->name('policy');
Route::get('/offer', function () {
    return view('pages/offer');
})->name('offer');


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->middleware(['auth'])->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/categories', [CategoriesController::class, 'mainCategories'])->name('categories');//CategoriesController
    Route::get('/categories/{id}', [CategoriesController::class, 'childCategories'])->name('categories_child');//CategoriesController

    Route::post('/search/{id}', [SearchItemsController::class, 'itemsByName'])->name('search_form');//SearchItemsController
    Route::get('/items/{id}', [SearchItemsController::class, 'itemsByCategory'])->name('get_item_by_cat');//SearchItemsController
    Route::post('/items/search/{id}', [SearchItemsController::class, 'itemsByName'])->name('search_cat_form');//SearchItemsController

    Route::get('/create/{id}', [CreateFileController::class, 'create_table'])->name('create');
    Route::get('/search-title', [SearchTitleController::class, 'SearchTitle'])->name('search-title');

    Route::get('/search-photo', function () {return view('pages/search-photo');})->name('search-photo');
    Route::post('/search-result', [SearchItemsController::class, 'itemsByImage'])->name('searchPhotoForm');
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

    Route::get('/tariffs', [TariffController::class, 'index'])->name('tariff');

});

Route::group(['middleware' => ['role:admin', 'auth'], 'prefix' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::resource('tariffs', TariffCrudController::class);
    Route::resource('user', UserCrudController::class);
    Route::resource('support', SupportCrudController::class);
    Route::resource('articles', ArticleCrudController::class);

});
