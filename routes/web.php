<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('categories.show');

Auth::routes();

// Redirect /home to dashboard for authenticated users, or to home for guests
Route::get('/home', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('home');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::resource('posts', PostController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
});