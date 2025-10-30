<?php

use Illuminate\Support\Facades\Route;
use App\Presentation\Http\Controllers\Web\HomeController;
use App\Presentation\Http\Controllers\Web\AboutController;
use App\Presentation\Http\Controllers\Web\BlogController;
use App\Presentation\Http\Controllers\Web\ContactController;
use App\Presentation\Http\Controllers\Admin\DashboardController;
use App\Presentation\Http\Controllers\Admin\BlogManagementController;
use App\Presentation\Http\Controllers\Admin\ContactManagementController;
use App\Presentation\Http\Controllers\Admin\ProfileManagementController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Blog Routes
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
});

// Contact Routes
Route::prefix('contact')->name('contact.')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::post('/', [ContactController::class, 'store'])->name('store');
});

// Admin Routes (protected by auth middleware)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Blog Management
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [BlogManagementController::class, 'index'])
            ->name('index');
        Route::get('/create', [BlogManagementController::class, 'create'])
            ->name('create');
        Route::post('/', [BlogManagementController::class, 'store'])
            ->name('store');
        Route::get('/{id}', [BlogManagementController::class, 'show'])
            ->name('show');
        Route::get('/{id}/edit', [BlogManagementController::class, 'edit'])
            ->name('edit');
        Route::put('/{id}', [BlogManagementController::class, 'update'])
            ->name('update');
        Route::delete('/{id}', [BlogManagementController::class, 'destroy'])
            ->name('destroy');
    });
    
    // Contact Management
    Route::prefix('contacts')->name('contact.')->group(function () {
        Route::get('/', [ContactManagementController::class, 'index'])
            ->name('index');
        Route::get('/{id}', [ContactManagementController::class, 'show'])   
            ->name('show');
        Route::patch('/{id}/mark-as-read', [ContactManagementController::class, 'markAsRead'])
            ->name('mark-as-read');
        Route::patch('/{id}/mark-as-unread', [ContactManagementController::class, 'markAsUnread'])
            ->name('mark-as-unread');
        Route::delete('/{id}', [ContactManagementController::class, 'destroy'])
            ->name('destroy');
    });
    
    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileManagementController::class, 'index'])
            ->name('index');
        Route::get('/edit', [ProfileManagementController::class, 'edit'])
            ->name('edit');
        Route::put('/', [ProfileManagementController::class, 'update'])
            ->name('update');
    });
});

// Authentication Routes will be added when setting up authentication system
