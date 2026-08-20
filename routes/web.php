<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Teknisi\DashboardController as TeknisiDashboard;
use App\Http\Controllers\Supervisor\DashboardController as SupervisorDashboard;
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

Route::middleware(['auth', 'role:super_admin'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboard::class, 'index'])->name('superadmin.dashboard');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:teknisi'])->prefix('teknisi')->group(function () {
    Route::get('/dashboard', [TeknisiDashboard::class, 'index'])->name('teknisi.dashboard');
});

Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->group(function () {
    Route::get('/dashboard', [SupervisorDashboard::class, 'index'])->name('supervisor.dashboard');
});

require __DIR__.'/auth.php';