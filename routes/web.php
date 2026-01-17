<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Home Routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('app.home');
Route::get('/posts', [App\Http\Controllers\HomeController::class, 'posts_list'])->name('app.posts_list');
Route::get('/post/{post}', [App\Http\Controllers\HomeController::class, 'post'])->name('app.post');
Route::get('/estates', [App\Http\Controllers\HomeController::class, 'estates_list'])->name('app.estates_list');
Route::get('/estate/{estate}', [App\Http\Controllers\HomeController::class, 'estate'])->name('app.estate');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('app.contact');
Route::get('/faq', [App\Http\Controllers\HomeController::class, 'faq'])->name('app.faq');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('app.about');
Route::get('/estate/type/{type}', [App\Http\Controllers\HomeController::class, 'estate_type'])->name('app.estate_type');
Route::get('/estate/city/{city}', [App\Http\Controllers\HomeController::class, 'estate_city'])->name('app.estate_city');
Route::get('/estate/{city}/{town}', [App\Http\Controllers\HomeController::class, 'estate_town'])->name('app.estate_town');
Route::get('/estates/search/', [App\Http\Controllers\HomeController::class, 'e_filter'])->name('app.e_filter');
Route::get('/lang', [App\Http\Controllers\HomeController::class, 'switch_lang'])->name('app.switch_lang');
Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('app.search');

Route::resource('contacts', App\Http\Controllers\ContactController::class)->only(['store']);
Route::resource('comments', App\Http\Controllers\CommentController::class)->only(['store']);

// Ajax Requests Routes
Route::post('/towns', [App\Http\Controllers\EstateController::class, 'towns']);
Route::post('/delete_img', [App\Http\Controllers\SettingController::class, 'delete_img']);
Route::post('/del_estateimg', [App\Http\Controllers\EstateController::class, 'del_estateimg']);


// Admin Routes
Route::prefix('admin')->group(function () {
  Auth::routes();

  Route::middleware(['auth'])->group(function () {
    Route::get('/index', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::resource('posts', App\Http\Controllers\PostController::class);
    Route::resource('comments', App\Http\Controllers\CommentController::class)->only(['index', 'destroy']);
    Route::resource('estates', App\Http\Controllers\EstateController::class);
    Route::resource('contacts', App\Http\Controllers\ContactController::class)->only(['index', 'destroy']);
    Route::resource('profile', App\Http\Controllers\ProfileController::class)->only(['index', 'update']);
    Route::resource('settings', App\Http\Controllers\SettingController::class)->only(['index', 'update']);
    Route::resource('faq', App\Http\Controllers\FaqController::class);
  });
});
