<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EngagementCalculatorController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/calculate', [EngagementCalculatorController::class, 'calculate']);
Route::post('/download-report', [EngagementCalculatorController::class, 'downloadReport']);

Route::get('/dashboard', [EngagementCalculatorController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
