<?php

use App\Http\Controllers\admin\AppointmentManagementController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\SpecialityController;
use App\Http\Controllers\admin\UserManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\psychologue\DashboardController as PsychologueDashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/psychologues', [UserController::class, 'allPsychologues'])
    ->name('psychologue.allPsychologues');

// register routes
Route::get('/register/patient', [AuthController::class, 'showPatientRegistrationForm'])->name('show.register.patient');
Route::get('/register/psychologue', [AuthController::class, 'showPsychologueRegistrationForm'])->name('show.register.psychologue');
Route::post('/register/patient', [AuthController::class, 'registerPatient'])->name('register.patient');
Route::post('/register/psychologue', [AuthController::class, 'registerPsychologue'])->name('register.psychologue');

// login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('show.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ADMIN LINK
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // user management routes 
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{user}/ban', [UserManagementController::class, 'ban'])->name('admin.users.ban');
    Route::post('/admin/users/{user}/unban', [UserManagementController::class, 'unban'])->name('admin.users.unban');
    Route::post('/admin/users/{user}/approve', [UserManagementController::class, 'approve'])->name('admin.users.approve');
    Route::post('/admin/users/{user}/reject', [UserManagementController::class, 'reject'])->name('admin.users.reject');
    // appointment management routes
    Route::get('/admin/appointmentManagement', [AppointmentManagementController::class, 'index'])->name('admin.appointments.index');
    Route::post('/admin/appointments/{appointment}/accept', [AppointmentManagementController::class, 'accept'])->name('admin.appointments.accept');
    Route::post('/admin/appointments/{appointment}/refuse', [AppointmentManagementController::class, 'refuse'])->name('admin.appointments.refuse');
    // speciality management routes
    Route::get('/admin/specialities', [SpecialityController::class, 'index'])->name('admin.speciality.index');
    Route::post('/admin/specialities', [SpecialityController::class, 'store'])->name('admin.speciality.store');
    Route::delete('/admin/specialities/{id}', [SpecialityController::class, 'destroy'])->name('admin.speciality.destroy');
});

// PATIENT LINK
Route::middleware(['auth', 'patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard');
    Route::get('/patient/reservation', [PatientDashboardController::class, 'reservation'])->name('patient.reservation');
    Route::post('/patient/reservation', [PatientDashboardController::class, 'storeReservation'])->name('patient.storeReservation');
    Route::get('/patient/rendezVous', [PatientDashboardController::class, 'rendezVous'])->name('patient.rendezVous');
    Route::get('/patient/profil', [PatientDashboardController::class, 'profil'])->name('patient.profil');
    Route::post('/patient/profil', [PatientDashboardController::class, 'updateProfil'])->name('patient.updateProfil');

    // AJAX Availability Routes (used during reservation)
    Route::get('/patient/get-available-dates/{psychologue}', [PatientDashboardController::class, 'getAvailableDates']);
    Route::get('/patient/get-available-times/{psychologue}/{date}', [PatientDashboardController::class, 'getAvailableTimes']);
});

// PSYCHOLOGUE LINK
Route::middleware(['auth', 'psychologue'])->group(function () {
    Route::get('/psychologue/dashboard', [PsychologueDashboardController::class, 'index'])->name('psychologue.dashboard');
    Route::get('/psychologue/profil', [PsychologueDashboardController::class, 'profil'])->name('psychologue.profil');
    Route::post('/psychologue/profil', [PsychologueDashboardController::class, 'updateProfil'])->name('psychologue.updateProfil');
    Route::get('/psychologue/disponabilite', [PsychologueDashboardController::class, 'disponabilite'])->name('psychologue.disponabilite');
    Route::post('/psychologue/disponabilite', [PsychologueDashboardController::class, 'storeDisponabilite'])->name('psychologue.storeDisponabilite');
    Route::delete('/psychologue/disponabilite/{id}', [PsychologueDashboardController::class, 'destroyDisponabilite'])->name('psychologue.destroyDisponabilite');
    Route::get('/psychologue/rendezVous', [PsychologueDashboardController::class, 'rendezVous'])->name('psychologue.rendezVous');
    Route::get('/psychologue/historique', [PsychologueDashboardController::class, 'historique'])->name('psychologue.historique');
});
