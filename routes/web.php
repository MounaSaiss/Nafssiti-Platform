<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PsychologueController;
use App\Http\Controllers\MeetingController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/psychologues', [PsychologueController::class, 'allPsychologues'])
    ->name('psychologue.allPsychologues');
Route::middleware(['auth'])->group(function () {
    Route::get('/meeting/{appointment}', [MeetingController::class, 'join'])->name('meeting.join');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/patient.php';
require __DIR__.'/psychologue.php';