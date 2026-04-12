<?php

namespace App\Http\Controllers\psychologue;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Refund;
use App\Models\Payment;

class AppointmentController extends Controller
{
    public function rendezVous(Request $request)
    {
        $psychologist = Auth::user()->psychologist;
        
        $query = Appointment::with(['patient.user'])
            ->where('psychologist_id', $psychologist->id)
            ->where('status', 'pending');

        $appointments = $query->latest('appointmentDate')
            ->latest('appointmentTime')
            ->get();

        return view('psychologue.appointmentManagement', compact('appointments'));
    }

    public function historique(Request $request)
    {
        $psychologist = Auth::user()->psychologist;
        
        $query = Appointment::with(['patient.user'])
            ->where('psychologist_id', $psychologist->id)
            ->whereIn('status', ['confirmed', 'rejected', 'cancelled']);

        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $appointments = $query->latest('appointmentDate')
            ->latest('appointmentTime')
            ->get();

        return view('psychologue.historique', compact('appointments'));
    }

    public function accept(Appointment $appointment)
    {
        $this->authorizeOwnership($appointment);

        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Ce rendez-vous n\'est plus en attente.');
        }

        $roomName = 'Nafssiti-' . Str::slug($appointment->patient->user->name) . '-' . Str::random(10);

        $appointment->update([
            'status' => 'confirmed',
            'jitsi_room_id' => $roomName
        ]);

        return back()->with('success', 'Rendez-vous accepté avec succès.');
    }

    public function refuse(Appointment $appointment, Request $request)
    {
        $this->authorizeOwnership($appointment);

        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Ce rendez-vous n\'est plus en attente.');
        }

        $defaultMessage = "Bonjour, Merci pour votre demande. Malheureusement, le créneau sélectionné n’est plus disponible ou ne peut pas être confirmé. Nous vous invitons à choisir un autre horaire. Nous vous remercions pour votre compréhension et restons à votre écoute.";

        $appointment->update([
            'status' => 'rejected',
            'rejection_reason' => $request->input('rejection_reason', $defaultMessage)
        ]);

        // Logic Remboursement Stripe
        $payment = Payment::where('appointment_id', $appointment->id)
            ->where('status', 'completed')
            ->first();

        if ($payment && $payment->stripe_id) {
            try {
                Stripe::setApiKey(env('STRIPE_SECRET'));
                Refund::create([
                    'payment_intent' => $payment->stripe_id,
                ]);
                
                $payment->update(['status' => 'refunded']);
            } catch (\Exception $e) {
                // Log l'erreur mais ne bloque pas le refus
                \Log::error('Erreur Remboursement Stripe: ' . $e->getMessage());
                return back()->with('success', 'Rendez-vous refusé, mais erreur lors du remboursement automatique. Veuillez vérifier sur votre interface Stripe.');
            }
        }

        return back()->with('success', 'Rendez-vous refusé' . ($payment ? ' et remboursé au patient.' : '.'));
    }

    public function complete(Appointment $appointment)
    {
        $this->authorizeOwnership($appointment);

        if ($appointment->status !== 'confirmed') {
            return back()->with('error', 'Seul un rendez-vous confirmé peut être terminé.');
        }

        $appointment->update(['consultation_status' => 'completed']);

        return back()->with('success', 'La séance a été marquée comme terminée. L\'accès est désormais clos.');
    }

    private function authorizeOwnership(Appointment $appointment)
    {
        if ($appointment->psychologist_id !== Auth::user()->psychologist->id) {
            abort(403, 'Action non autorisée.');
        }
    }
}
