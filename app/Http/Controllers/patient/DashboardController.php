<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\patient\PatientAppointmentsFilterRequest;
use App\Models\Psychologist;
use App\Models\Availability;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $appointmentsCount = $user->appointments()->count();
        
        $nextAppointment = $user->appointments()
            ->with('psychologist.user')
            ->where('appointmentDate', '>=', now()->toDateString())
            ->orderBy('appointmentDate')
            ->orderBy('appointmentTime')
            ->first();

        return view("patient.dashboard", compact('appointmentsCount', 'nextAppointment'));
    }
    public function reservation()
    {
        $psychologues = Psychologist::with('user')->where('validationStatus', 'approved')->get();
        return view("patient.reservation", compact('psychologues'));
    }

    public function getAvailableDates($psychologist_id)
    {
        $dates = Availability::where('psychologist_id', $psychologist_id)
            ->where('date', '>=', now()->toDateString())
            ->whereDoesntHave('appointments', function($query) {
                $query->whereIn('status', ['pending', 'confirmed']);
            })
            ->distinct()
            ->pluck('date');

        return response()->json($dates);
    }

    public function getAvailableTimes($psychologist_id, $date)
    {
        $availabilities = Availability::where('psychologist_id', $psychologist_id)
            ->where('date', $date)
            ->get();

        $slots = [];
        foreach ($availabilities as $avail) {
            $start = Carbon::parse($avail->start_time);
            $end = Carbon::parse($avail->end_time);

            // Create slots of 60 minutes
            while ($start->copy()->addMinutes(60)->lte($end)) {
                $timeSlot = $start->format('H:i:s');
                
                // NEW: Skip if the date is today and the time slot has already passed
                if ($date === now()->toDateString() && $start->lt(now())) {
                    $start->addMinutes(60);
                    continue;
                }

                // Check if this specific slot is already booked
                $isBooked = Appointment::where('availability_id', $avail->id)
                    ->where('appointmentTime', $timeSlot)
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->exists();

                if (!$isBooked) {
                    $slots[] = [
                        'availability_id' => $avail->id,
                        'time' => $start->format('H:i'),
                        'full_time' => $timeSlot
                    ];
                }
                $start->addMinutes(60);
            }
        }

        return response()->json($slots);
    }

    public function storeReservation(Request $request)
    {
        $request->validate([
            'psychologist_id' => 'required|exists:psychologists,id',
            'availability_id' => 'required|exists:availabilities,id',
            'appointment_time' => 'required',
        ]);

        $availability = Availability::findOrFail($request->availability_id);

        // NEW: Double check if the time hasn't passed if the date is today
        if ($availability->date === now()->toDateString()) {
            $appointmentTime = Carbon::parse($request->appointment_time);
            if ($appointmentTime->lt(now())) {
                return redirect()->back()->with('error', 'Désolé, ce créneau horaire est déjà passé.');
            }
        }

        // Double check if this specific slot is still available
        $isBooked = Appointment::where('availability_id', $availability->id)
            ->where('appointmentTime', $request->appointment_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($isBooked) {
            return redirect()->back()->with('error', 'Désolé, ce créneau vient d\'être réservé par un autre utilisateur.');
        }

        // Check if the patient already has another appointment at the same time
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
        ]);

        return redirect()->route('patient.rendezVous')->with('success', 'Votre réservation a été envoyée avec succès.');
    }

    public function rendezVous(PatientAppointmentsFilterRequest $request)
    {
        $user = Auth::user();
        $statusFilter = $request->input('status', 'à-venir');
        
        $query = $user->appointments()->with('psychologist.user');

        if ($statusFilter === 'à-venir') {
            $query->where('status', 'confirmed')
                  ->where('appointmentDate', '>=', now()->toDateString());
        } elseif ($statusFilter === 'en-attente') {
            $query->where('status', 'pending');
        } elseif ($statusFilter === 'historique') {
            $query->where(function($q) {
                $q->where(function($sq) {
                    $sq->where('status', 'confirmed')
                       ->where('appointmentDate', '<', now()->toDateString());
                })->orWhere('status', 'completed')
                  ->orWhere('status', 'rejected');
            });
        }

        $appointments = $query->orderBy('appointmentDate', $statusFilter === 'historique' ? 'desc' : 'asc')
            ->orderBy('appointmentTime', $statusFilter === 'historique' ? 'desc' : 'asc')
            ->get();

        return view("patient.rendezVous", compact('appointments', 'statusFilter'));
    }
    public function profil(){
        return view("patient.profil");
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = bcrypt($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Votre profil a été mis à jour avec succès.');
    }
}
