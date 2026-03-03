<?php

use App\Http\Controllers;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ─── Public Routes (Inertia) ───────────────────────────────────────
Route::get('/', [Controllers\Front\PageController::class, 'home'])->name('app.home');
Route::get('about', [Controllers\Front\PageController::class, 'about'])->name('app.about');
Route::get('faq', [Controllers\Front\PageController::class, 'faq'])->name('app.faq');

Route::get('contact', [Controllers\Front\PublicContactController::class, 'contact'])->name('app.contact');
Route::post('contacts', [Controllers\Front\PublicContactController::class, 'store'])->name('app.contact.store');

Route::get('posts', [Controllers\Front\PublicPostController::class, 'posts'])->name('app.posts');
Route::get('post/{post:slug}', [Controllers\Front\PublicPostController::class, 'post'])->name('app.post');
Route::post('post/{post}/comment', [Controllers\Front\PublicPostController::class, 'storeComment'])->name('app.post.comment');

Route::get('estates/search', [Controllers\Front\PublicEstateController::class, 'filterEstate'])->name('app.estate_filter');
Route::get('estate/{estate:slug}', [Controllers\Front\PublicEstateController::class, 'estate'])->name('app.estate');
Route::get('estates', [Controllers\Front\PublicEstateController::class, 'estates'])->name('app.estates');
Route::post('towns', [Controllers\Front\PublicEstateController::class, 'fetchTownsByCityId']);

Route::get('lang', [Controllers\Front\LanguageController::class, 'switchLang'])->name('app.switch_lang');
Route::get('search', [Controllers\Front\SearchController::class, 'search'])->name('app.search');

// ─── Admin Routes (Auth via Breeze) ────────────────────────────────
Route::middleware('auth')->group(function () {

    // Breeze Profile (Vue)
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// Admin resources (still Blade — to be converted)
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('posts', Controllers\PostController::class);
    Route::resource('comments', Controllers\CommentController::class)->only(['index', 'destroy']);
    Route::resource('estates', Controllers\EstateController::class);
    Route::delete('estates/delete-image/{estate}', [Controllers\EstateController::class, 'deleteImage']);
    Route::resource('contacts', Controllers\ContactController::class)->only(['index', 'destroy']);
    Route::resource('faq', Controllers\FaqController::class);

    Route::get('settings', [Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::put('settings/update', [Controllers\SettingController::class, 'update'])->name('settings.update');
    Route::delete('settings/delete-image', [Controllers\SettingController::class, 'deleteImage'])->name('settings.deleteImage');
});

require __DIR__ . '/auth.php';
