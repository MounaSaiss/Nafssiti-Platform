<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Psychologist;
use App\Models\Appointment;
use App\Models\TherapeuticObjective;
use App\Models\Recommendation;

class SharedRoomController extends Controller
{
    public function index($psychologist_id)
    {
        $patient = Auth::user()->patient;
        $psychologist = Psychologist::with('user')->findOrFail($psychologist_id);

        // 1. Les rendez-vous à venir et passés
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('psychologist_id', $psychologist_id)
            ->where('status', 'confirmed')
            ->where('appointmentDate', '>=', now()->toDateString())
            ->orderBy('appointmentDate')
            ->orderBy('appointmentTime')
            ->get();

        $pastAppointments = Appointment::where('patient_id', $patient->id)
            ->where('psychologist_id', $psychologist_id)
            ->where('status', 'completed')
            ->orderBy('appointmentDate', 'desc')
            ->get();

        // 2. Les objectifs thérapeutiques (Lecture seule pour le patient)
        $objectives = TherapeuticObjective::where('patient_id', $patient->id)
            ->where('psychologist_id', $psychologist_id)
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        // 3. Les recommandations du psychologue
        $recommendations = Recommendation::where('patient_id', $patient->id)
            ->where('psychologist_id', $psychologist_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('patient.shared_room.index', compact(
            'psychologist', 
            'upcomingAppointments', 
            'pastAppointments', 
            'objectives', 
            'recommendations'
        ));
    }
}
