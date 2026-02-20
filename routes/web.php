<?php

use App\Http\Controllers;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ─── Public Routes (Inertia) ───────────────────────────────────────
Route::get('/', [Controllers\HomeController::class, 'index']);
Route::get('home', [Controllers\HomeController::class, 'index'])->name('app.home');
Route::get('about', [Controllers\HomeController::class, 'about'])->name('app.about');
Route::get('posts', [Controllers\HomeController::class, 'posts'])->name('app.posts');
Route::get('faq', [Controllers\HomeController::class, 'faq'])->name('app.faq');
Route::get('contact', [Controllers\HomeController::class, 'contact'])->name('app.contact');
Route::get('post/{post}', [Controllers\HomeController::class, 'post'])->name('app.post');
Route::get('estate/{estate}', [Controllers\HomeController::class, 'estate'])->name('app.estate');

// ─── Public Routes (Still Blade — to be converted) ────────────────
Route::get('estates', [Controllers\HomeController::class, 'estates'])->name('app.estates');
Route::get('estate/type/{type}', [Controllers\HomeController::class, 'filterByType'])->name('app.estate_type');
Route::get('estate/city/{city}', [Controllers\HomeController::class, 'filterByCity'])->name('app.estate_city');
Route::get('estate/{city}/{town}', [Controllers\HomeController::class, 'filterByTown'])->name('app.estate_town');
Route::get('estates/search/', [Controllers\HomeController::class, 'filterEstate'])->name('app.estate_filter');
Route::get('lang', [Controllers\HomeController::class, 'switchLang'])->name('app.switch_lang');
Route::get('search', [Controllers\HomeController::class, 'search'])->name('app.search');

Route::resource('contacts', Controllers\ContactController::class)->only(['store']);
Route::resource('comments', Controllers\CommentController::class)->only(['store']);

// ─── Ajax Routes ───────────────────────────────────────────────────
Route::post('towns', [Controllers\EstateController::class, 'towns']);
Route::post('delete-setting-image', [Controllers\SettingController::class, 'deleteImage']);
Route::post('delete-estate-image', [Controllers\EstateController::class, 'deleteImage']);

// ─── Admin Routes (Auth via Breeze) ────────────────────────────────
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Breeze Profile (Vue)
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin resources (still Blade — to be converted)
    Route::prefix('admin')->group(function () {
        Route::get('/', [Controllers\AdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('posts', Controllers\PostController::class);
        Route::resource('comments', Controllers\CommentController::class)->only(['index', 'destroy']);
        Route::resource('estates', Controllers\EstateController::class);
        Route::resource('contacts', Controllers\ContactController::class)->only(['index', 'destroy']);
        Route::resource('faq', Controllers\FaqController::class);

        Route::get('settings', [Controllers\SettingController::class, 'index'])->name('settings.index');
        Route::put('settings/update', [Controllers\SettingController::class, 'update'])->name('settings.update');
        Route::delete('settings/delete-image', [Controllers\SettingController::class, 'deleteImage'])->name('settings.deleteImage');
    });
});

require __DIR__ . '/auth.php';
