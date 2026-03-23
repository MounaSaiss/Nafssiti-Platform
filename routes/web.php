<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\UserGestionController;
use App\Http\Controllers\admin\AppointmentsGestionController;
use App\Http\Controllers\admin\SpecialityController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\psychologue\DashboardController as PsychologueDashboardController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/psychologues', [UserController::class, 'allPsychologues'])
    ->name('psychologue.allPsychologues');


//register routes
Route::get('/register/patient', [AuthController::class, 'showPatientRegistrationForm'])->name('show.register.patient');
Route::get('/register/psychologue', [AuthController::class, 'showPsychologueRegistrationForm'])->name('show.register.psychologue');
Route::post('/register/patient', [AuthController::class, 'registerPatient'])->name('register.patient');
Route::post('/register/psychologue', [AuthController::class, 'registerPsychologue'])->name('register.psychologue');

//login routes 
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('show.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ADMIN LINK 
//admin 
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/userGestion', [UserGestionController::class, 'userGestion'])->name('admin.userGestion');
Route::get('/admin/appointmentsGestion', [AppointmentsGestionController::class, 'appointmentsGestion'])->name('admin.appointmentsGestion');
Route::get('/admin/specialities', [SpecialityController::class, 'index'])->name('admin.speciality.index');
Route::post('/admin/specialities', [SpecialityController::class, 'store'])->name('admin.speciality.store');
Route::delete('/admin/specialities/{id}', [SpecialityController::class, 'destroy'])->name('admin.speciality.destroy');
//approve psychologist
Route::get('/admin/approvePsychologist/{id}', [AdminDashboardController::class, 'approvePsychologist'])->name('admin.approvePsychologist');
Route::get('/admin/rejectPsychologist/{id}', [AdminDashboardController::class, 'rejectPsychologist'])->name('admin.rejectPsychologist');
//ban user
Route::post('/admin/banUser/{id}', [UserGestionController::class, 'banUser'])->name('admin.banUser');
Route::post('/admin/unbanUser/{id}', [UserGestionController::class, 'unbanUser'])->name('admin.unbanUser');
//appointment actions
Route::post('/admin/appointments/{id}/accept', [AppointmentsGestionController::class, 'acceptAppointment'])->name('admin.acceptAppointment');
Route::post('/admin/appointments/{id}/refuse', [AppointmentsGestionController::class, 'refuseAppointment'])->name('admin.refuseAppointment');



// PATIENT LINK 
// patient 
Route::get('/patient/dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard');
Route::get('/patient/reservation', [PatientDashboardController::class, 'reservation'])->name('patient.reservation');
Route::post('/patient/reservation', [PatientDashboardController::class, 'storeReservation'])->name('patient.storeReservation');
Route::get('/patient/rendezVous', [PatientDashboardController::class, 'rendezVous'])->name('patient.rendezVous');
Route::get('/patient/profil', [PatientDashboardController::class, 'profil'])->name('patient.profil');
Route::post('/patient/profil', [PatientDashboardController::class, 'updateProfil'])->name('patient.updateProfil');

// AJAX Availability Routes
Route::get('/patient/get-available-dates/{psychologue}', [PatientDashboardController::class, 'getAvailableDates']);
Route::get('/patient/get-available-times/{psychologue}/{date}', [PatientDashboardController::class, 'getAvailableTimes']);





// PSYCHOLOGUE LINK 
//psychologue 
Route::get('/psychologue/dashboard', [PsychologueDashboardController::class, 'index'])->name('psychologue.dashboard');
Route::get('/psychologue/profil', [PsychologueDashboardController::class, 'profil'])->name('psychologue.profil');
Route::post('/psychologue/profil', [PsychologueDashboardController::class, 'updateProfil'])->name('psychologue.updateProfil');
Route::get('/psychologue/disponabilite', [PsychologueDashboardController::class, 'disponabilite'])->name('psychologue.disponabilite');
Route::post('/psychologue/disponabilite', [PsychologueDashboardController::class, 'storeDisponabilite'])->name('psychologue.storeDisponabilite');
Route::delete('/psychologue/disponabilite/{id}', [PsychologueDashboardController::class, 'destroyDisponabilite'])->name('psychologue.destroyDisponabilite');
Route::get('/psychologue/rendezVous', [PsychologueDashboardController::class, 'rendezVous'])->name('psychologue.rendezVous');
Route::get('/psychologue/historique', [PsychologueDashboardController::class, 'historique'])->name('psychologue.historique');