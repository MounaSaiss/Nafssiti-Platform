<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\patient\StoreReservationRequest;
use App\Models\Appointment;
use App\Models\Psychologist;
use App\Services\ReservationLogicService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    protected $reservationService;
    // Inject la logique de reservation qui affiche all time in date give it in url 
    public function __construct(ReservationLogicService $reservationService)
    {
        $this->reservationService = $reservationService;
    }
    public function reservation(Request $request)
    {
        $psychologues = Psychologist::with('user')->where('validationStatus', 'approved')->get();

        $selectedPsychologistId = $request->query('psychologist_id');
        $selectedDate = $request->query('appointment_date');

        $availableFree = [];

        if ($selectedPsychologistId && $selectedDate) {
            $availableFree = $this->reservationService->getAvailableSlots($selectedPsychologistId, $selectedDate);
        }

        return view('patient.reservation', compact(
            'psychologues',
            'selectedPsychologistId',
            'selectedDate',
            'availableFree'
        ));
    }

    public function storeReservation(StoreReservationRequest $request)
    {
        Appointment::create([
            'patient_id'      => Auth::user()->patient->id,
            'psychologist_id' => $request->psychologist_id,
            'appointmentDate' => $request->appointment_date,
            'appointmentTime' => $request->appointment_time,
            'status'          => 'pending',
            'notes'           => $request->notes,
        ]);

        return redirect()->route('patient.rendezVous')
            ->with('success', 'Votre réservation a été envoyée avec succès.');
    }
}
