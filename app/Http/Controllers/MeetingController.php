<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MeetingController extends Controller
{
    public function join(Appointment $appointment)
    {
        // Check if user is authorized to join this meeting
        $user = Auth::user();
        $isPatient = $user->patient && $user->patient->id === $appointment->patient_id;
        $isPsychologist = $user->psychologist && $user->psychologist->id === $appointment->psychologist_id;

        if (!$isPatient && !$isPsychologist) {
            abort(403, 'Accès non autorisé à cette réunion.');
        }

        if ($appointment->status !== 'confirmed') {
            return back()->with('error', 'Cette réunion n\'est pas encore confirmée.');
        }

        if ($appointment->consultation_status === 'completed') {
            return back()->with('error', 'Cette séance est déjà terminée et n\'est plus accessible.');
        }

        // Psychologist starts the session
        if ($user->isPsychologue()) {
            $appointment->update(['is_started' => true]);
        }

        // Patient can only join if session is started
        if ($user->isPatient() && !$appointment->is_started) {
            return back()->with('error', 'Le psychologue n\'a pas encore démarré la séance. Veuillez patienter.');
        }

        if (!$appointment->jitsi_room_id) {
            // Generate one on the fly for old appointments
            $roomName = 'Nafssiti-' . Str::slug($appointment->patient->user->name ?? 'User') . '-' . Str::random(10);
            $appointment->update(['jitsi_room_id' => $roomName]);
        }

        return view('shared.jitsi_room', compact('appointment'));
    }
}
