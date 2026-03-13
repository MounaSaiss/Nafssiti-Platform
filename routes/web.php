<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\UserGestionController;
use App\Http\Controllers\admin\AppointmentsGestionController;
use App\Http\Controllers\admin\DashboardController;

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

//admin 
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/userGestion', [UserGestionController::class, 'userGestion'])->name('admin.userGestion');
Route::get('/admin/appointmentsGestion', [AppointmentsGestionController::class, 'appointmentsGestion'])->name('admin.appointmentsGestion');

//approve psychologist
Route::get('/admin/approvePsychologist/{id}', [DashboardController::class, 'approvePsychologist'])->name('admin.approvePsychologist');
Route::get('/admin/rejectPsychologist/{id}', [DashboardController::class, 'rejectPsychologist'])->name('admin.rejectPsychologist');

//ban user
Route::post('/admin/banUser/{id}', [UserGestionController::class, 'banUser'])->name('admin.banUser');
Route::post('/admin/unbanUser/{id}', [UserGestionController::class, 'unbanUser'])->name('admin.unbanUser');

//appointment actions
Route::post('/admin/appointments/{id}/accept', [AppointmentsGestionController::class, 'acceptAppointment'])->name('admin.acceptAppointment');
Route::post('/admin/appointments/{id}/refuse', [AppointmentsGestionController::class, 'refuseAppointment'])->name('admin.refuseAppointment');