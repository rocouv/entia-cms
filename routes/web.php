<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\MediaController;
use App\Http\Controllers\Dashboard\PageController;
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\SiteSettingsController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/servicios', [PublicController::class, 'services'])->name('services.index');
Route::get('/servicios/{slug}', [PublicController::class, 'service'])->name('services.show');
Route::get('/proyectos', [PublicController::class, 'projects'])->name('projects.index');
Route::get('/proyectos/{slug}', [PublicController::class, 'project'])->name('projects.show');

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
    Route::resource('/dashboard/categories', CategoryController::class)
        ->except('show')
        ->names('dashboard.categories');
    Route::resource('/dashboard/services', ServiceController::class)
        ->except('show')
        ->names('dashboard.services');
    Route::resource('/dashboard/projects', ProjectController::class)
        ->except('show')
        ->names('dashboard.projects');
    Route::get('/dashboard/pages/{page}/sections', [SectionController::class, 'index'])->name('dashboard.sections.index');
    Route::get('/dashboard/pages/{page}/sections/create', [SectionController::class, 'create'])->name('dashboard.sections.create');
    Route::post('/dashboard/pages/{page}/sections', [SectionController::class, 'store'])->name('dashboard.sections.store');
    Route::get('/dashboard/pages/{page}/sections/{section}/edit', [SectionController::class, 'edit'])->name('dashboard.sections.edit');
    Route::put('/dashboard/pages/{page}/sections/{section}', [SectionController::class, 'update'])->name('dashboard.sections.update');
    Route::delete('/dashboard/pages/{page}/sections/{section}', [SectionController::class, 'destroy'])->name('dashboard.sections.destroy');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard/settings', [SiteSettingsController::class, 'edit'])->name('dashboard.settings.edit');
        Route::put('/dashboard/settings', [SiteSettingsController::class, 'update'])->name('dashboard.settings.update');

        Route::resource('/dashboard/users', UserController::class)
            ->except('show')
            ->names('dashboard.users');
    });
});

Route::get('/{slug}', [PublicController::class, 'show'])->name('pages.show');
