<?php

use App\Http\Controllers\CaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PersonnelController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Case Management Routes
    Route::resource('cases', CaseController::class);
    
    // Personnel Management Routes
    Route::resource('personnel', PersonnelController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
