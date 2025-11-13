<?php

use Illuminate\Support\Facades\Route;
use App\Presentation\Http\Controllers\Web\HomeController;
use App\Presentation\Http\Controllers\Web\AboutController;
use App\Presentation\Http\Controllers\Web\BlogController;
use App\Presentation\Http\Controllers\Admin\DashboardController;
use App\Presentation\Http\Controllers\Admin\BlogManagementController;
use App\Presentation\Http\Controllers\Admin\ProfileManagementController;
use App\Presentation\Http\Controllers\Auth\AuthController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Blog Routes
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (protected by auth middleware)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [BlogManagementController::class, 'index'])->name('index');
        Route::get('/create', [BlogManagementController::class, 'create'])->name('create');
        Route::post('/', [BlogManagementController::class, 'store'])->name('store');
        Route::get('/{slug}', [BlogManagementController::class, 'show'])->name('show');
        Route::get('/{slug}/edit', [BlogManagementController::class, 'edit'])->name('edit');
        Route::put('/{slug}', [BlogManagementController::class, 'update'])->name('update');
        Route::delete('/{slug}', [BlogManagementController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileManagementController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileManagementController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileManagementController::class, 'update'])->name('update');
    });

});
