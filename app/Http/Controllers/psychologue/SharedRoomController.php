<?php

namespace App\Http\Controllers\psychologue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\PrivateNote;
use App\Models\TherapeuticObjective;
use App\Models\Recommendation;

class SharedRoomController extends Controller
{
    public function index($patient_id)
    {
        $psychologist = Auth::user()->psychologist;
        
        // On s'assure de récupérer le compte User lié au patient
        $patient = Patient::with('user')->findOrFail($patient_id);

        $upcomingAppointments = Appointment::where('psychologist_id', $psychologist->id)
            ->where('patient_id', $patient_id)
            ->where('status', 'confirmed')
            ->where('appointmentDate', '>=', now()->toDateString())
            ->orderBy('appointmentDate')
            ->orderBy('appointmentTime')
            ->get();

        $pastAppointments = Appointment::where('psychologist_id', $psychologist->id)
            ->where('patient_id', $patient_id)
            ->where('status', 'completed')
            ->orderBy('appointmentDate', 'desc')
            ->get();

        $privateNotes = PrivateNote::where('psychologist_id', $psychologist->id)
            ->where('patient_id', $patient_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $objectives = TherapeuticObjective::where('psychologist_id', $psychologist->id)
            ->where('patient_id', $patient_id)
            ->orderBy('status', 'asc') // 'en cours' avant 'atteint'
            ->orderBy('created_at', 'desc')
            ->get();

        $recommendations = Recommendation::where('psychologist_id', $psychologist->id)
            ->where('patient_id', $patient_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('psychologue.shared_room.index', compact(
            'patient',
            'upcomingAppointments',
            'pastAppointments',
            'privateNotes',
            'objectives',
            'recommendations'
        ));
    }

    public function updatePatientInfo(Request $request, $patient_id)
    {
        $request->validate([
            'date_of_birth' => 'nullable|date',
            'problematique_principale' => 'nullable|string'
        ]);

        $patient = Patient::findOrFail($patient_id);
        $patient->update($request->only(['date_of_birth', 'problematique_principale']));

        return back()->with('success', 'Informations patient mises à jour.');
    }

    public function storePrivateNote(Request $request, $patient_id)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $psychologist = Auth::user()->psychologist;

        PrivateNote::create([
            'psychologist_id' => $psychologist->id,
            'patient_id' => $patient_id,
            'content' => $request->content
        ]);

        return back()->with('success', 'Note clinique ajoutée (visible uniquement par vous).');
    }

    public function storeObjective(Request $request, $patient_id)
    {
        $request->validate([
            'description' => 'required|string'
        ]);

        $psychologist = Auth::user()->psychologist;

        TherapeuticObjective::create([
            'psychologist_id' => $psychologist->id,
            'patient_id' => $patient_id,
            'description' => $request->description,
            'status' => 'en cours'
        ]);

        return back()->with('success', 'Objectif thérapeutique ajouté.');
    }

    public function updateObjectiveStatus($objective_id)
    {
        $psychologist = Auth::user()->psychologist;
        $objective = TherapeuticObjective::where('psychologist_id', $psychologist->id)->findOrFail($objective_id);

        $objective->update([
            'status' => $objective->status === 'en cours' ? 'atteint' : 'en cours'
        ]);

        return back()->with('success', 'Statut de l\'objectif mis à jour.');
    }

    public function storeRecommendation(Request $request, $patient_id)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $psychologist = Auth::user()->psychologist;

        Recommendation::create([
            'psychologist_id' => $psychologist->id,
            'patient_id' => $patient_id,
            'content' => $request->content
        ]);

        return back()->with('success', 'Recommandation envoyée au patient.');
    }

    public function destroyPrivateNote($id)
    {
        $psychologist = Auth::user()->psychologist;
        PrivateNote::where('psychologist_id', $psychologist->id)->findOrFail($id)->delete();
        return back()->with('success', 'Note supprimée.');
    }

    public function destroyObjective($id)
    {
        $psychologist = Auth::user()->psychologist;
        TherapeuticObjective::where('psychologist_id', $psychologist->id)->findOrFail($id)->delete();
        return back()->with('success', 'Objectif supprimé.');
    }

    public function destroyRecommendation($id)
    {
        $psychologist = Auth::user()->psychologist;
        Recommendation::where('psychologist_id', $psychologist->id)->findOrFail($id)->delete();
        return back()->with('success', 'Recommandation supprimée.');
    }

    public function storeAppointment(Request $request, $patient_id)
    {
        $request->validate([
            'appointmentDate' => 'required|date|after_or_equal:today',
            'appointmentTime' => 'required'
        ]);

        $psychologist = Auth::user()->psychologist;

        $isBlocked = \App\Models\Unavailability::where('psychologist_id', $psychologist->id)
            ->where('date', $request->appointmentDate)
            ->where(function ($query) use ($request) {
                $endSlot = \Carbon\Carbon::parse($request->appointmentTime)->addHour()->toTimeString();
                $query->where('start_time', '<', $endSlot)
                      ->where('end_time', '>', $request->appointmentTime);
            })
            ->exists();

        if ($isBlocked) {
            return back()->with('error', 'Vous avez marqué ce créneau comme indisponible dans votre planning.');
        }

        $isBooked = Appointment::where('psychologist_id', $psychologist->id)
            ->where('appointmentDate', $request->appointmentDate)
            ->where('appointmentTime', $request->appointmentTime)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($isBooked) {
            return back()->with('error', 'Ce créneau est déjà réservé pour un autre rendez-vous.');
        }

        Appointment::create([
            'patient_id' => $patient_id,
            'psychologist_id' => $psychologist->id,
            'appointmentDate' => $request->appointmentDate,
            'appointmentTime' => $request->appointmentTime,
            'status' => 'confirmed',
            'consultation_status' => 'pending'
        ]);

        return back()->with('success', 'Nouveau rendez-vous planifié avec succès.');
    }
}
