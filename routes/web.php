<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EngagementCalculatorController;
use App\Http\Controllers\StrategyCallController;

Route::get('/', [EngagementCalculatorController::class, 'index']);
Route::get('/calculator', [EngagementCalculatorController::class, 'index'])->name('calculator');

Route::post('/calculate', [EngagementCalculatorController::class, 'calculate']);
Route::post('/download-report', [EngagementCalculatorController::class, 'downloadReport']);

Route::post('/api/strategy-call', [StrategyCallController::class, 'submit'])->name('api.strategy-call');

Route::get('/dashboard', [EngagementCalculatorController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\Auth\SocialLoginController;

Route::middleware('guest')->group(function () {
    Route::get('/auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])->name('social.redirect');
    Route::get('/auth/{provider}/callback', [SocialLoginController::class, 'callback'])->name('social.callback');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/leads', [\App\Http\Controllers\AdminController::class, 'leads'])->name('admin.leads');
    Route::get('/leads/export', [\App\Http\Controllers\AdminController::class, 'exportLeads'])->name('admin.leads.export');
    Route::get('/settings', [\App\Http\Controllers\AdminSettingController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [\App\Http\Controllers\AdminSettingController::class, 'update'])->name('admin.settings.update');
    Route::post('/settings/currencies', [\App\Http\Controllers\AdminSettingController::class, 'addCurrency'])->name('admin.currencies.add');
    Route::delete('/settings/currencies/{id}', [\App\Http\Controllers\AdminSettingController::class, 'deleteCurrency'])->name('admin.currencies.delete');
    
    // Benchmarks
    Route::resource('/benchmarks', \App\Http\Controllers\AdminBenchmarkController::class)->except(['show']);
    
    // Report Template Editor
    Route::get('/report-template', [\App\Http\Controllers\AdminTemplateController::class, 'edit'])->name('admin.template.edit');
    Route::post('/report-template', [\App\Http\Controllers\AdminTemplateController::class, 'update'])->name('admin.template.update');

    // Admin Profile
    Route::get('/profile', [\App\Http\Controllers\AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/profile', [\App\Http\Controllers\AdminController::class, 'updateProfile'])->name('admin.profile.update');
});
