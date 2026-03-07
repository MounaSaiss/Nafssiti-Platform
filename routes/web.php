<?php

use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\auth\registerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [loginController::class, 'showLoginForm'])->name('login');
Route::get('/register/user', [registerController::class, 'showRegistrationForm'])->name('register.user');
Route::get('/register/psychologue', [registerController::class, 'showPsychologueRegistrationForm'])->name('register.psychologue');
Route::get('/psychologues', [UserController::class, 'allPsychologues'])
    ->name('psychologue.allPsychologues');