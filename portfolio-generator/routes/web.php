<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\WorkExperienceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/portfolio/create', [PortfolioController::class, 'create'])->name('portfolio.create');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/portfolio/create', [PortfolioController::class, 'create'])->name('portfolio.create');
    Route::post('/portfolio/store', [PortfolioController::class, 'store'])->name('portfolio.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/portfolio/{portfolio}/edit', [PortfolioController::class, 'edit'])->name('portfolio.edit');
    Route::put('/portfolio/{portfolio}', [PortfolioController::class, 'update'])->name('portfolio.update');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/portfolio/{portfolio}/education', [EducationController::class, 'index'])->name('education.index');
    Route::post('/portfolio/{portfolio}/education', [EducationController::class, 'store'])->name('education.store');
});

Route::middleware(['auth'])->group(function () {
   Route::get('/portfolio/{portfolio}/experience', [WorkExperienceController::class, 'index'])->name('experience.index');
   Route::post('/portfolio/{portfolio}/experience', [WorkExperienceController::class, 'store'])->name('experience.store');

});

require __DIR__.'/auth.php';
