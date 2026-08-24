<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\RoleController as SuperAdminRoleController;
use App\Http\Controllers\SuperAdmin\CategoryController as SuperAdminCategoryController;
use App\Http\Controllers\SuperAdmin\PriorityController as SuperAdminPriorityController;
use App\Http\Controllers\SuperAdmin\UnitController as SuperAdminUnitController;
use App\Http\Controllers\SuperAdmin\TechnicianController as SuperAdminTechnicianController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;

use App\Http\Controllers\Teknisi\TeknisiController;
use App\Http\Controllers\Supervisor\DashboardController as SupervisorDashboard;

use App\Http\Controllers\Guest\GuestTicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public / Guest Portal Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [GuestTicketController::class, 'landing'])->name('guest.landing');
Route::get('/guest/ticket/create', [GuestTicketController::class, 'create'])->name('guest.ticket.create');
Route::post('/guest/ticket', [GuestTicketController::class, 'store'])->name('guest.ticket.store');
Route::get('/guest/ticket/success/{ticket_number}', [GuestTicketController::class, 'success'])->name('guest.ticket.success');
Route::get('/guest/ticket/track', [GuestTicketController::class, 'track'])->name('guest.ticket.track');
Route::post('/guest/ticket/{ticket_number}/attachment', [GuestTicketController::class, 'uploadAttachment'])->name('guest.ticket.attachment');
Route::post('/guest/ticket/{ticket_number}/feedback', [GuestTicketController::class, 'submitFeedback'])->name('guest.ticket.feedback');

/*
|--------------------------------------------------------------------------
| Common Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $role = auth()->user()?->role?->name;
    return match ($role) {
        'super_admin' => redirect()->route('superadmin.dashboard'),
        'admin' => redirect()->route('admin.dashboard'),
        'teknisi' => redirect()->route('teknisi.dashboard'),
        'supervisor' => redirect()->route('supervisor.dashboard'),
        default => view('dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| A. Super Admin Routes (Master Data & App Configuration)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboard::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', SuperAdminUserController::class);
    Route::patch('/users/{user}/toggle-status', [SuperAdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Role Management
    Route::get('/roles', [SuperAdminRoleController::class, 'index'])->name('roles.index');
    
    // Ticket Categories Management
    Route::resource('categories', SuperAdminCategoryController::class)->except(['create', 'show', 'edit']);
    
    // Priorities & SLA Configuration Management
    Route::resource('priorities', SuperAdminPriorityController::class)->except(['create', 'show', 'edit']);
    
    // Units / Departments Management
    Route::resource('units', SuperAdminUnitController::class)->except(['create', 'show', 'edit']);
    
    // Technician Data Management
    Route::get('/technicians', [SuperAdminTechnicianController::class, 'index'])->name('technicians.index');
    Route::get('/technicians/{technician}/edit', [SuperAdminTechnicianController::class, 'edit'])->name('technicians.edit');
    Route::put('/technicians/{technician}', [SuperAdminTechnicianController::class, 'update'])->name('technicians.update');
});

/*
|--------------------------------------------------------------------------
| B. Admin Routes (Helpdesk Operator / Triage & Dispatch)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // Ticket Management
    Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/validate', [AdminTicketController::class, 'validateTicket'])->name('tickets.validate');
    Route::post('/tickets/{ticket}/reject', [AdminTicketController::class, 'rejectTicket'])->name('tickets.reject');
    Route::post('/tickets/{ticket}/triage', [AdminTicketController::class, 'updateTriage'])->name('tickets.triage');
    Route::post('/tickets/{ticket}/assign', [AdminTicketController::class, 'assignTechnician'])->name('tickets.assign');
    Route::post('/tickets/{ticket}/notes', [AdminTicketController::class, 'addNote'])->name('tickets.notes');
    Route::post('/tickets/{ticket}/close', [AdminTicketController::class, 'closeTicket'])->name('tickets.close');
});

/*
|--------------------------------------------------------------------------
| C. Teknisi Routes (Updated with Named Routes & Riwayat Page)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:teknisi'])->prefix('teknisi')->name('teknisi.')->group(function () {
    Route::get('/dashboard', [TeknisiController::class, 'index'])->name('dashboard');
    Route::post('/tickets/{ticket}/status', [TeknisiController::class, 'updateStatus'])->name('status.update');
    Route::post('/tickets/{ticket}/notes', [TeknisiController::class, 'addNote'])->name('notes.store');
    Route::get('/riwayat', [TeknisiController::class, 'riwayat'])->name('riwayat');
});

/*
|--------------------------------------------------------------------------
| D. Supervisor IT Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('/dashboard', [SupervisorDashboard::class, 'index'])->name('dashboard');
    
    // TAMBAHAN: Route Monitoring SLA
    Route::get('/monitoring-sla', [SupervisorDashboard::class, 'monitoringSla'])->name('monitoring-sla');
});

require __DIR__.'/auth.php';