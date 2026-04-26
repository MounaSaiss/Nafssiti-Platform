<?php

namespace App\Http\Controllers\psychologue;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Unavailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function getEvents()
    {
        $psychologist = Auth::user()->psychologist;
        $events = [];

        // 1. Récupérer les Rendez-vous
        $appointments = Appointment::where('psychologist_id', $psychologist->id)
            ->with('patient.user')
            ->get();

        foreach ($appointments as $appointment) {
            $events[] = [
                'id' => 'apt_' . $appointment->id,
                'title' => 'RDV: ' . ($appointment->patient->user->name ?? 'Patient'),
                'start' => $appointment->appointmentDate . 'T' . $appointment->appointmentTime,
                // On estime une durée de 1h par défaut si non spécifiée
                'end' => date('Y-m-d\TH:i:s', strtotime($appointment->appointmentDate . ' ' . $appointment->appointmentTime . ' +1 hour')),
                'backgroundColor' => $appointment->status === 'confirmed' ? '#3da903ff' : '#f1092fff',
                'borderColor' => $appointment->status === 'confirmed' ? '#3da903ff' : '#f1092fff',
                'extendedProps' => [
                    'type' => 'appointment',
                    'status' => $appointment->status,
                    'patient' => $appointment->patient->user->name ?? 'Patient'
                ]
            ];
        }

        // 2. Récupérer les Indisponibilités (Blocages)
        $unavailabilities = Unavailability::where('psychologist_id', $psychologist->id)->get();

        foreach ($unavailabilities as $unavailability) {
            $events[] = [
                'id' => 'unavail_' . $unavailability->id,
                'title' => 'Indisponible',
                'start' => $unavailability->date . 'T' . $unavailability->start_time,
                'end' => $unavailability->date . 'T' . $unavailability->end_time,
                'backgroundColor' => '#1e293b',
                'borderColor' => '#1e293b',
                'extendedProps' => [
                    'type' => 'unavailability'
                ]
            ];
        }
        return response()->json($events);
    }

    public function storeQuickEvent(Request $request)
    {
        $psychologist = Auth::user()->psychologist;
        
        if (!$psychologist) {
            return response()->json(['status' => 'error', 'message' => 'Profil psychologue non trouvé.'], 403);
        }

        $type = $request->input('type');

        if ($type === 'appointment') {
            // Validation
            if (!$request->input('patient_id')) {
                return response()->json(['status' => 'error', 'message' => 'Veuillez sélectionner un patient.'], 422);
            }

            $appointment = Appointment::create([
                'psychologist_id' => $psychologist->id,
                'patient_id' => $request->input('patient_id'),
                'appointmentDate' => $request->input('date'),
                'appointmentTime' => $request->input('start_time'),
                'status' => 'confirmed',
                'consultation_status' => 'pending',
                'notes' => $request->input('notes'),
            ]);

            // Recharger les relations pour avoir le nom du patient dans la réponse
            $appointment->load('patient.user');

            return response()->json([
                'status' => 'success',
                'message' => 'Rendez-vous créé avec succès.',
                'event' => [
                    'id' => 'apt_' . $appointment->id,
                    'title' => 'RDV: ' . $appointment->patient->user->name,
                    'start' => $appointment->appointmentDate . 'T' . $appointment->appointmentTime,
                    'backgroundColor' => '#4dbfbf'
                ]
            ]);
        } else {
            // Validation pour indisponibilité
            if (!$request->input('start_time') || !$request->input('end_time')) {
                return response()->json(['status' => 'error', 'message' => 'Heures de début et de fin requises.'], 422);
            }

            $unavailability = Unavailability::create([
                'psychologist_id' => $psychologist->id,
                'date' => $request->input('date'),
                'start_time' => $request->input('start_time'),
                'end_time' => $request->input('end_time'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Indisponibilité enregistrée.',
                'event' => [
                    'id' => 'unavail_' . $unavailability->id,
                    'title' => 'Indisponible',
                    'start' => $unavailability->date . 'T' . $unavailability->start_time,
                    'end' => $unavailability->date . 'T' . $unavailability->end_time,
                    'backgroundColor' => '#1e293b'
                ]
            ]);
        }
    }
}
