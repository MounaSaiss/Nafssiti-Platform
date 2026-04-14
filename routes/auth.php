<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// register routes
Route::get('/register/patient', [AuthController::class, 'showPatientRegistrationForm'])->name('show.register.patient');
Route::get('/register/psychologue', [AuthController::class, 'showPsychologueRegistrationForm'])->name('show.register.psychologue');
Route::post('/register/patient', [AuthController::class, 'registerPatient'])->name('register.patient');
Route::post('/register/psychologue', [AuthController::class, 'registerPsychologue'])->name('register.psychologue');

// login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('show.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
