<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PostModerationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    }
    return app(App\Http\Controllers\HomeController::class)->index();
})->name('home');

Route::get('/welcome', [HomeController::class, 'index'])->name('welcome');
Route::get('/post/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('categories.show');

Auth::routes();

// Redirect /home based on user role
Route::get('/home', function () {
    if (auth()->check()) {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    }
    return redirect()->route('home');
});

// User routes (authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::resource('posts', PostController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
});

// Admin routes (admin role only)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Post moderation routes
    Route::get('/posts', [PostModerationController::class, 'index'])->name('posts.index');
    Route::patch('/posts/{post}/approve', [PostModerationController::class, 'approve'])->name('posts.approve');
    Route::patch('/posts/{post}/decline', [PostModerationController::class, 'decline'])->name('posts.decline');
    Route::post('/posts/bulk-action', [PostModerationController::class, 'bulkAction'])->name('posts.bulk-action');
});