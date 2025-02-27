<?php

use App\Http\Middleware\CheckAdmin;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeeklyPickController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\ShowcaseController;
use App\Http\Controllers\ProfilePageController;
use App\Http\Controllers\WeeklyPickPanelController;
use App\Http\Controllers\WeeklyPickOutcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});


// admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource("weekly-pick-panel", WeeklyPickPanelController::class);

    Route::resource("weekly-pick-outcome", WeeklyPickOutcomeController::class);

    Route::resource("showcase", ShowcaseController::class);
});


// kazdy user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/weekly-pick', [WeeklyPickController::class, 'show'])->name('weekly-pick.show');
    Route::post('/weekly-pick', [WeeklyPickController::class, 'store'])->name('weekly-pick.store');

    Route::get('/ranking', [RankingController::class, 'show'])->name('dashboard');

    Route::resource("profile-page", ProfilePageController::class);

    
});

require __DIR__.'/auth.php';
