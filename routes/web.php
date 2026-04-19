<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\patient\ReservationController as PatientReservationController;
use App\Http\Controllers\patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\patient\ProfileController as PatientProfileController;
use App\Http\Controllers\psychologue\DashboardController as PsychologueDashboardController;
use App\Http\Controllers\psychologue\ProfileController as PsychologueProfileController;
use App\Http\Controllers\psychologue\UnavailabilityController as PsychologueUnavailabilityController;
use App\Http\Controllers\psychologue\AppointmentController as PsychologueAppointmentController;
use App\Http\Controllers\psychologue\CalendarController;
use App\Http\Controllers\psychologue\FollowRequestController as PsychologueFollowRequestController;
use App\Http\Controllers\patient\BilanSeanceController as PatientBilanSeanceController;
use App\Http\Controllers\patient\FollowRequestController as PatientFollowRequestController;
use App\Http\Controllers\PsychologueController;
use App\Http\Controllers\MeetingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/psychologues', [PsychologueController::class, 'allPsychologues'])
    ->name('psychologue.allPsychologues');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/meeting/{appointment}', [MeetingController::class, 'join'])->name('meeting.join');
});



// PATIENT LINK
Route::middleware(['auth', 'patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard');
    Route::get('/patient/reservation', [PatientReservationController::class, 'reservation'])->name('patient.reservation');
    Route::post('/patient/reservation', [App\Http\Controllers\patient\StripePaymentController::class, 'checkout'])->name('patient.storeReservation');
    
    // Stripe Payments
    Route::get('/patient/payment/success', [App\Http\Controllers\patient\StripePaymentController::class, 'success'])->name('patient.payment.success');
    Route::get('/patient/payment/cancel', [App\Http\Controllers\patient\StripePaymentController::class, 'cancel'])->name('patient.payment.cancel');

    Route::get('/patient/rendezVous', [PatientAppointmentController::class, 'rendezVous'])->name('patient.rendezVous');
    Route::get('/patient/bilan-seance', [PatientBilanSeanceController::class, 'index'])->name('patient.bilan_seance');
    Route::post('/patient/bilan-seance/{appointment}/follow', [PatientFollowRequestController::class, 'store'])->name('patient.follow_request.store');
    Route::get('/patient/profil', [PatientProfileController::class, 'profil'])->name('patient.profil');
    Route::post('/patient/profil', [PatientProfileController::class, 'updateProfil'])->name('patient.updateProfil');

    // Shared Room
    Route::get('/patient/mon-suivi/{psychologist}', [App\Http\Controllers\patient\SharedRoomController::class, 'index'])->name('patient.shared_room.index');
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
