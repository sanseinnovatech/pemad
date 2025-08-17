<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReviewController;


Route::get('/', function () {
    return view('welcome');
})->middleware(['guest']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/change-profile-avatar', [DashboardController::class, 'changeAvatar'])->name('change-profile-avatar');
    Route::delete('/remove-profile-avatar', [DashboardController::class, 'removeAvatar'])->name('remove-profile-avatar');

    Route::middleware(['can:admin'])->group(function () {
        Route::resource('user', UserController::class);
    });
});
Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::resource('product', ProductController::class)
        ->scoped(['product' => 'id'])
        ->whereNumber('product');
    Route::resource('category', CategoryController::class)->except(['show']);
    Route::resource('review', ReviewController::class)->only(['index', 'destroy']);
});
