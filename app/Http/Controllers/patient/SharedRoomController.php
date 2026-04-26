<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
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

        // recupération des rendez vous à venir 
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('psychologist_id', $psychologist_id)
            ->where('status', 'confirmed')
            ->where('appointmentDate', '>=', now()->toDateString())
            ->orderBy('appointmentDate')
            ->orderBy('appointmentTime')
            ->get();
        // recupération des rendez vous passés 
        $pastAppointments = Appointment::where('patient_id', $patient->id)
            ->where('psychologist_id', $psychologist_id)
            ->where('status', 'completed')
            ->orderBy('appointmentDate', 'desc')
            ->get();
        // recupération des objectifs thérapeutiques 
        $objectives = TherapeuticObjective::where('patient_id', $patient->id)
            ->where('psychologist_id', $psychologist_id)
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        // recupération des recommandations du psychologue
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
