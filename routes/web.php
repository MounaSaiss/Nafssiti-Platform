<?php

use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\auth\registerController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Runner\HookMethod;
use App\Http\Controllers\HomeController;


Route::get('/',[HomeController::class, 'index'])->name('home');
Route::get('/login', [loginController::class, 'showLoginForm'])->name('login');
Route::get('/register/user', [registerController::class, 'showRegistrationForm'])->name('register.user');
Route::get('/register/psychologue', [registerController::class, 'showPsychologueRegistrationForm'])->name('register.psychologue');


