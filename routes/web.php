<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EngagementCalculatorController;

Route::get('/', [EngagementCalculatorController::class, 'index']);
Route::get('/calculator', [EngagementCalculatorController::class, 'index'])->name('calculator');

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

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/leads', [\App\Http\Controllers\AdminController::class, 'leads'])->name('admin.leads');
    Route::get('/leads/export', [\App\Http\Controllers\AdminController::class, 'exportLeads'])->name('admin.leads.export');
    Route::get('/settings', [\App\Http\Controllers\AdminSettingController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [\App\Http\Controllers\AdminSettingController::class, 'update'])->name('admin.settings.update');
    
    // Benchmarks
    Route::resource('/benchmarks', \App\Http\Controllers\AdminBenchmarkController::class)->except(['show']);
    
    // Report Template Editor
    Route::get('/report-template', [\App\Http\Controllers\AdminTemplateController::class, 'edit'])->name('admin.template.edit');
    Route::post('/report-template', [\App\Http\Controllers\AdminTemplateController::class, 'update'])->name('admin.template.update');
});
