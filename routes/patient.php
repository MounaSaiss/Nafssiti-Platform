<?php
use App\Http\Controllers\patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\patient\BilanSeanceController as PatientBilanSeanceController;
use App\Http\Controllers\patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\patient\FollowRequestController as PatientFollowRequestController;
use App\Http\Controllers\patient\ProfileController as PatientProfileController;
use App\Http\Controllers\patient\ReservationController as PatientReservationController;
use App\Http\Controllers\patient\SharedRoomController as PatientSharedRoomController;
use App\Http\Controllers\patient\StripePaymentController as PatientStripePaymentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard');

    Route::get('/patient/reservation', [PatientReservationController::class, 'reservation'])->name('patient.reservation');

    Route::post('/patient/payment', [PatientStripePaymentController::class, 'checkout'])->name('patient.payment');
    Route::get('/patient/payment/success', [PatientStripePaymentController::class, 'success'])->name('patient.payment.success');
    Route::get('/patient/payment/cancel', [PatientStripePaymentController::class, 'cancel'])->name('patient.payment.cancel');

    Route::get('/patient/rendezVous', [PatientAppointmentController::class, 'rendezVous'])->name('patient.rendezVous');
    Route::get('/patient/bilan-seance', [PatientBilanSeanceController::class, 'index'])->name('patient.bilan_seance');
    Route::post('/patient/bilan-seance/{appointment}/follow', [PatientFollowRequestController::class, 'store'])->name('patient.follow_request.store');
    Route::get('/patient/profil', [PatientProfileController::class, 'profil'])->name('patient.profil');
    Route::post('/patient/profil', [PatientProfileController::class, 'updateProfil'])->name('patient.updateProfil');

    // Shared Room
    Route::get('/patient/mon-suivi/{psychologist}', [PatientSharedRoomController::class, 'index'])->name('patient.shared_room.index');
});
