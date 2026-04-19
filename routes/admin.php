<?php

use App\Http\Controllers\admin\AppointmentManagementController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\SpecialityController;
use App\Http\Controllers\admin\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // user management 
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{user}/ban', [UserManagementController::class, 'ban'])->name('admin.users.ban');
    Route::post('/admin/users/{user}/unban', [UserManagementController::class, 'unban'])->name('admin.users.unban');
    Route::post('/admin/users/{user}/approve', [UserManagementController::class, 'approve'])->name('admin.users.approve');
    Route::post('/admin/users/{user}/reject', [UserManagementController::class, 'reject'])->name('admin.users.reject');
    // appointment management 
    Route::get('/admin/appointmentManagement', [AppointmentManagementController::class, 'index'])->name('admin.appointments.index');
    Route::post('/admin/appointments/{appointment}/accept', [AppointmentManagementController::class, 'accept'])->name('admin.appointments.accept');
    Route::post('/admin/appointments/{appointment}/refuse', [AppointmentManagementController::class, 'refuse'])->name('admin.appointments.refuse');
    // speciality management 
    Route::get('/admin/specialities', [SpecialityController::class, 'index'])->name('admin.speciality.index');
    Route::post('/admin/specialities', [SpecialityController::class, 'store'])->name('admin.speciality.store');
    Route::delete('/admin/specialities/{id}', [SpecialityController::class, 'destroy'])->name('admin.speciality.destroy');
});