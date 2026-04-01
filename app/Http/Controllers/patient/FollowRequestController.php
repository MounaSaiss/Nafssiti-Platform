<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\FollowRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowRequestController extends Controller
{
    public function store(Request $request, Appointment $appointment)
    {
        $user = Auth::user();
        $patient = $user->patient;

        // Vérifier que le rendez-vous appartient au patient connecté
        if ($appointment->patient_id !== $patient->id) {
            abort(403);
        }

        // Vérifier que la consultation est bien terminée
        if ($appointment->consultation_status !== 'completed') {
            return redirect()->route('patient.bilan_seance')
                ->with('error', 'Vous ne pouvez pas encore soumettre un bilan.');
        }

        // Créer la demande de suivi si elle n'existe pas déjà
        FollowRequest::firstOrCreate([
            'patient_id'      => $patient->id,
            'psychologist_id' => $appointment->psychologist_id,
        ], [
            'status' => 'pending',
        ]);

        return redirect()->route('patient.bilan_seance')
            ->with('success', 'Votre demande de suivi a bien été envoyée. Elle est en attente d\'acceptation par le psychologue.');
    }
}
