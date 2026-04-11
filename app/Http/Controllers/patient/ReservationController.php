<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\patient\StoreReservationRequest;
use App\Models\Appointment;
use App\Models\Unavailability;
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
        $selectedDate = $request->query('appointment_date');

        $availableFree = [];

        if ($selectedPsychologistId && $selectedDate) {
            $availableFree = $this->calculateAvailable($selectedPsychologistId, $selectedDate);
        }

        return view('patient.reservation', compact(
            'psychologues',
            'selectedPsychologistId',
            'selectedDate',
            'availableFree'
        ));
    }

    private function calculateAvailable($psychologist_id, $date)
    {
        $carbonDate = Carbon::parse($date);
        $dayOfWeek = $carbonDate->dayOfWeek; // 0 (Sunday) through 6 (Saturday)

        // Set limits based on the day of the week
        if ($dayOfWeek === Carbon::SUNDAY) {
            return []; // Dimanche chômé
        } elseif ($dayOfWeek === Carbon::SATURDAY) {
            $startLimit = 9; // 09:00
            $endLimit = 14;  // 14:00
        } else {
            // Lundi à Vendredi
            $startLimit = 9; // 09:00
            $endLimit = 18;  // 18:00
        }

        $unavailabilities = Unavailability::where('psychologist_id', $psychologist_id)
            ->where('date', $date)
            ->get();

        $bookedAppointments = Appointment::where('psychologist_id', $psychologist_id)
            ->where('appointmentDate', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        $free = [];
        
        for ($hour = $startLimit; $hour < $endLimit; $hour++) {
            $startTimeStr = sprintf('%02d:00:00', $hour);
            $endTimeStr = sprintf('%02d:00:00', $hour + 1);
            
            $startSlot = Carbon::parse($date . ' ' . $startTimeStr);
            $endSlot = $startSlot->copy()->addHour();

            // 1. Check if past today
            if ($date === now()->toDateString() && $startSlot->lt(now())) {
                continue;
            }

            // 2. Check overlap with unavailabilities
            $isUnavailable = false;
            foreach ($unavailabilities as $unavail) {
                $uStart = Carbon::parse($date . ' ' . $unavail->start_time);
                $uEnd = Carbon::parse($date . ' ' . $unavail->end_time);

                // Overlap check: (SlotStart < UnavailEnd) AND (SlotEnd > UnavailStart)
                if ($startSlot->lt($uEnd) && $endSlot->gt($uStart)) {
                    $isUnavailable = true;
                    break;
                }
            }
            if ($isUnavailable) continue;

            // 3. Check if already booked
            $isBooked = $bookedAppointments->contains(function($app) use ($startTimeStr) {
                return $app->appointmentTime === $startTimeStr;
            });

            if (!$isBooked) {
                $free[] = [
                    'time' => $startSlot->format('H:i'),
                    'full_time' => $startTimeStr,
                ];
            }
        }

        return $free;
    }

    public function storeReservation(StoreReservationRequest $request)
    {
        $psychologist_id = $request->psychologist_id;
        $appointmentDate = $request->appointment_date;
        $appointmentTime = $request->appointment_time;

        if ($appointmentDate === now()->toDateString()) {
            if (Carbon::parse($appointmentDate . ' ' . $appointmentTime)->lt(now())) {
                return redirect()->back()->with('error', 'Désolé, ce créneau horaire est déjà passé.');
            }
        }

        $carbonDate = Carbon::parse($appointmentDate);
        $dayOfWeek = $carbonDate->dayOfWeek;
        $appointmentHour = (int)Carbon::parse($appointmentTime)->format('H');

        if ($dayOfWeek === Carbon::SUNDAY) {
            return redirect()->back()->with('error', 'Désolé, le dimanche est un jour non travaillé.');
        } elseif ($dayOfWeek === Carbon::SATURDAY) {
            if ($appointmentHour < 9 || $appointmentHour >= 14) {
                return redirect()->back()->with('error', 'Désolé, les horaires du samedi sont de 09:00 à 14:00.');
            }
        } else {
            if ($appointmentHour < 9 || $appointmentHour >= 18) {
                return redirect()->back()->with('error', 'Désolé, les horaires de semaine sont de 09:00 à 18:00.');
            }
        }

        // Check if overlaps with unavailabilities
        $isUnavailable = Unavailability::where('psychologist_id', $psychologist_id)
            ->where('date', $appointmentDate)
            ->where(function ($query) use ($appointmentTime) {
                $endSlot = Carbon::parse($appointmentTime)->addHour()->toTimeString();
                $query->where('start_time', '<', $endSlot)
                      ->where('end_time', '>', $appointmentTime);
            })
            ->exists();

        if ($isUnavailable) {
            return redirect()->back()->with('error', 'Désolé, le praticien n\'est pas disponible à ce moment.');
        }

        // Check if already booked
        $isBooked = Appointment::where('psychologist_id', $psychologist_id)
            ->where('appointmentDate', $appointmentDate)
            ->where('appointmentTime', $appointmentTime)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($isBooked) {
            return redirect()->back()->with('error', 'Désolé, ce créneau vient d\'être réservé par un autre utilisateur.');
        }

        $patientConflict = Appointment::where('patient_id', Auth::user()->patient->id)
            ->where('appointmentDate', $appointmentDate)
            ->where('appointmentTime', $appointmentTime)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($patientConflict) {
            return redirect()->back()->with('error', 'Vous avez déjà un rendez-vous prévu à cette heure-là.');
        }

        Appointment::create([
            'patient_id' => Auth::user()->patient->id,
            'psychologist_id' => $psychologist_id,
            'appointmentDate' => $appointmentDate,
            'appointmentTime' => $appointmentTime,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('patient.rendezVous')->with('success', 'Votre réservation a été envoyée avec succès.');
    }
}
