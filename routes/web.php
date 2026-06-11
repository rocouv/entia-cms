<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\MediaController;
use App\Http\Controllers\Dashboard\PageController;
use App\Http\Controllers\Dashboard\SiteSettingsController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/dashboard/media', [MediaController::class, 'index'])->name('dashboard.media.index');
    Route::get('/dashboard/media/create', [MediaController::class, 'create'])->name('dashboard.media.create');
    Route::post('/dashboard/media', [MediaController::class, 'store'])->name('dashboard.media.store');
    Route::delete('/dashboard/media/{media}', [MediaController::class, 'destroy'])->name('dashboard.media.destroy');
    Route::resource('/dashboard/pages', PageController::class)
        ->except('show')
        ->names('dashboard.pages');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard/settings', [SiteSettingsController::class, 'edit'])->name('dashboard.settings.edit');
        Route::put('/dashboard/settings', [SiteSettingsController::class, 'update'])->name('dashboard.settings.update');

        Route::resource('/dashboard/users', UserController::class)
            ->except('show')
            ->names('dashboard.users');
    });
});
