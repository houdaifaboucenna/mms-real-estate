<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Home Routes
Route::get('/', [Controllers\HomeController::class, 'index']);
Route::get('home', [Controllers\HomeController::class, 'index'])->name('app.home');
Route::get('posts', [Controllers\HomeController::class, 'posts'])->name('app.posts');
Route::get('post/{post}', [Controllers\HomeController::class, 'post'])->name('app.post');
Route::get('estates', [Controllers\HomeController::class, 'estates'])->name('app.estates');
Route::get('estate/{estate}', [Controllers\HomeController::class, 'estate'])->name('app.estate');
Route::get('contact', [Controllers\HomeController::class, 'contact'])->name('app.contact');
Route::get('faq', [Controllers\HomeController::class, 'faq'])->name('app.faq');
Route::get('about', [Controllers\HomeController::class, 'about'])->name('app.about');
Route::get('estate/type/{type}', [Controllers\HomeController::class, 'filterByType'])->name('app.estate_type');
Route::get('estate/city/{city}', [Controllers\HomeController::class, 'filterByCity'])->name('app.estate_city');
Route::get('estate/{city}/{town}', [Controllers\HomeController::class, 'filterByTown'])->name('app.estate_town');
Route::get('estates/search/', [Controllers\HomeController::class, 'filterEstate'])->name('app.estate_filter');
Route::get('lang', [Controllers\HomeController::class, 'switchLang'])->name('app.switch_lang');
Route::get('search', [Controllers\HomeController::class, 'search'])->name('app.search');

Route::resource('contacts', Controllers\ContactController::class)->only(['store']);
Route::resource('comments', Controllers\CommentController::class)->only(['store']);

// Ajax Requests Routes
Route::post('towns', [Controllers\EstateController::class, 'towns']);
Route::post('delete-setting-image', [Controllers\SettingController::class, 'deleteImage']);
Route::post('delete-estate-image', [Controllers\EstateController::class, 'deleteImage']);

// Admin Routes
Route::prefix('admin')->group(function () {
    Auth::routes();

    Route::middleware(['auth'])->group(function () {
        Route::get('index', [Controllers\AdminController::class, 'index'])->name('dashboard');
        Route::resource('posts', Controllers\PostController::class);
        Route::resource('comments', Controllers\CommentController::class)->only(['index', 'destroy']);
        Route::resource('estates', Controllers\EstateController::class);
        Route::resource('contacts', Controllers\ContactController::class)->only(['index', 'destroy']);
        Route::resource('profile', Controllers\ProfileController::class)->only(['index', 'update']);
        Route::resource('settings', Controllers\SettingController::class)->only(['index', 'update']);
        Route::resource('faq', Controllers\FaqController::class);
    });
});
