<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\patient\StoreReservationRequest;
use App\Models\Appointment;
use App\Models\Availability;
use App\Models\Psychologist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function reservation(Request $request)
    {
        $psychologues = Psychologist::with('user')->where('validationStatus', 'approved')->get();

        $selectedPsychologistId = $request->query('psychologist_id');
        $selectedDate = $request->query('date');

        $availableDates = [];
        $availableFree = [];

        if ($selectedPsychologistId) {
            $availableDates = Availability::where('psychologist_id', $selectedPsychologistId)
                ->where('date', '>=', now()->toDateString())
                ->distinct()
                ->pluck('date');

            if ($selectedDate) {
                $availableFree = $this->calculateAvailable($selectedPsychologistId, $selectedDate);
            }
        }

        return view('patient.reservation', compact(
            'psychologues',
            'selectedPsychologistId',
            'selectedDate',
            'availableDates',
            'availableFree'
        ));
    }

    private function calculateAvailable($psychologist_id, $date)
    {
        $availabilities = Availability::where('psychologist_id', $psychologist_id)
            ->where('date', $date)
            ->get();

        $free = [];
        foreach ($availabilities as $avail) {
            $start = Carbon::parse($avail->start_time);
            $end = Carbon::parse($avail->end_time);

            while ($start->copy()->addMinutes(60)->lte($end)) {
                $timeSlot = $start->format('H:i:s');

                if ($date === now()->toDateString() && $start->lt(now())) {
                    $start->addMinutes(60);

                    continue;
                }

                $isBooked = Appointment::where('availability_id', $avail->id)
                    ->where('appointmentTime', $timeSlot)
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->exists();

                if (! $isBooked) {
                    $free[] = [
                        'availability_id' => $avail->id,
                        'time' => $start->format('H:i'),
                        'full_time' => $timeSlot,
                    ];
                }
                $start->addMinutes(60);
            }
        }

        return $free;
    }

    public function storeReservation(StoreReservationRequest $request)
    {
        $availability = Availability::findOrFail($request->availability_id);

        if ($availability->date === now()->toDateString()) {
            $appointmentTime = Carbon::parse($request->appointment_time);
            if ($appointmentTime->lt(now())) {
                return redirect()->back()->with('error', 'Désolé, ce créneau horaire est déjà passé.');
            }
        }

        $isBooked = Appointment::where('availability_id', $availability->id)
            ->where('appointmentTime', $request->appointment_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($isBooked) {
            return redirect()->back()->with('error', 'Désolé, ce créneau vient d\'être réservé par un autre utilisateur.');
        }

        $patientConflict = Appointment::where('patient_id', Auth::user()->patient->id)
            ->where('appointmentDate', $availability->date)
            ->where('appointmentTime', $request->appointment_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($patientConflict) {
            return redirect()->back()->with('error', 'Vous avez déjà un rendez-vous prévu à cette heure-là.');
        }

        Appointment::create([
            'patient_id' => Auth::user()->patient->id,
            'psychologist_id' => $request->psychologist_id,
            'availability_id' => $request->availability_id,
            'appointmentDate' => $availability->date,
            'appointmentTime' => $request->appointment_time,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('patient.rendezVous')->with('success', 'Votre réservation a été envoyée avec succès.');
    }
}
