<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\psychologue\DashboardController as PsychologueDashboardController;
use App\Http\Controllers\psychologue\ProfileController as PsychologueProfileController;
use App\Http\Controllers\psychologue\UnavailabilityController as PsychologueUnavailabilityController;
use App\Http\Controllers\psychologue\AppointmentController as PsychologueAppointmentController;
use App\Http\Controllers\psychologue\CalendarController;
use App\Http\Controllers\psychologue\FollowRequestController as PsychologueFollowRequestController;
use App\Http\Controllers\PsychologueController;
use App\Http\Controllers\MeetingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/psychologues', [PsychologueController::class, 'allPsychologues'])
    ->name('psychologue.allPsychologues');

Route::middleware(['auth'])->group(function () {
    Route::get('/meeting/{appointment}', [MeetingController::class, 'join'])->name('meeting.join');
});


// PSYCHOLOGUE LINK
Route::middleware(['auth', 'psychologue'])->group(function () {
    Route::get('/psychologue/dashboard', [PsychologueDashboardController::class, 'index'])->name('psychologue.dashboard');
    Route::get('/psychologue/api/events', [CalendarController::class, 'getEvents'])->name('psychologue.calendar.events');
    Route::post('/psychologue/api/calendar/quick-store', [CalendarController::class, 'storeQuickEvent'])->name('psychologue.calendar.quickStore');
    Route::get('/psychologue/profil', [PsychologueProfileController::class, 'profil'])->name('psychologue.profil');
    Route::post('/psychologue/profil', [PsychologueProfileController::class, 'updateProfil'])->name('psychologue.updateProfil');
    Route::get('/psychologue/disponabilite', [PsychologueUnavailabilityController::class, 'indisponabilite'])->name('psychologue.disponabilite');
    Route::post('/psychologue/disponabilite', [PsychologueUnavailabilityController::class, 'storeIndisponabilite'])->name('psychologue.storeDisponabilite');
    Route::delete('/psychologue/disponabilite/{id}', [PsychologueUnavailabilityController::class, 'destroyIndisponabilite'])->name('psychologue.destroyDisponabilite');
    Route::get('/psychologue/rendezVous', [PsychologueAppointmentController::class, 'rendezVous'])->name('psychologue.rendezVous');
    Route::post('/psychologue/appointments/{appointment}/accept', [PsychologueAppointmentController::class, 'accept'])->name('psychologue.appointments.accept');
    Route::post('/psychologue/appointments/{appointment}/refuse', [PsychologueAppointmentController::class, 'refuse'])->name('psychologue.appointments.refuse');
    Route::post('/psychologue/appointments/{appointment}/complete', [PsychologueAppointmentController::class, 'complete'])->name('psychologue.appointments.complete');
    Route::get('/psychologue/historique', [PsychologueAppointmentController::class, 'historique'])->name('psychologue.historique');
    Route::get('/psychologue/follow-requests', [PsychologueFollowRequestController::class, 'index'])->name('psychologue.follow_requests.index');
    Route::patch('/psychologue/follow-requests/{followRequest}/accept', [PsychologueFollowRequestController::class, 'accept'])->name('psychologue.follow_requests.accept');
    Route::patch('/psychologue/follow-requests/{followRequest}/reject', [PsychologueFollowRequestController::class, 'reject'])->name('psychologue.follow_requests.reject');

    // Shared Room (Dossier Patient)
    Route::prefix('psychologue/dossiers')->name('psychologue.shared_room.')->group(function () {
        Route::get('/{patient}', [App\Http\Controllers\psychologue\SharedRoomController::class, 'index'])->name('index');
        Route::post('/{patient}/info', [App\Http\Controllers\psychologue\SharedRoomController::class, 'updatePatientInfo'])->name('updatePatientInfo');
        Route::post('/{patient}/private-note', [App\Http\Controllers\psychologue\SharedRoomController::class, 'storePrivateNote'])->name('storePrivateNote');
        Route::delete('/private-note/{id}', [App\Http\Controllers\psychologue\SharedRoomController::class, 'destroyPrivateNote'])->name('destroyPrivateNote');
        Route::post('/{patient}/objective', [App\Http\Controllers\psychologue\SharedRoomController::class, 'storeObjective'])->name('storeObjective');
        Route::patch('/objective/{id}/status', [App\Http\Controllers\psychologue\SharedRoomController::class, 'updateObjectiveStatus'])->name('updateObjectiveStatus');
        Route::delete('/objective/{id}', [App\Http\Controllers\psychologue\SharedRoomController::class, 'destroyObjective'])->name('destroyObjective');
        Route::post('/{patient}/recommendation', [App\Http\Controllers\psychologue\SharedRoomController::class, 'storeRecommendation'])->name('storeRecommendation');
        Route::delete('/recommendation/{id}', [App\Http\Controllers\psychologue\SharedRoomController::class, 'destroyRecommendation'])->name('destroyRecommendation');
        Route::post('/{patient}/appointment', [App\Http\Controllers\psychologue\SharedRoomController::class, 'storeAppointment'])->name('storeAppointment');
    });
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/patient.php';