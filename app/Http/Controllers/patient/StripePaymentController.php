<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\patient\StoreReservationRequest;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Psychologist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripePaymentController extends Controller
{
    public function checkout(StoreReservationRequest $request)
    { 
        $psychologist = Psychologist::findOrFail($request->psychologist_id);
        return $this->createStripeSession($psychologist, $request);
    }
    private function createStripeSession($psychologist, $request)
    {
        // Configuration de clé secrète qui est dans .env 
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $amount = ($psychologist->pricePerSession ?? 50) * 100;

        // création de session sur stripe 
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'mad',
                    'product_data' => ['name' => 'Consultation avec Dr. '.$psychologist->user->name],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('patient.payment.success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('patient.payment.cancel'),
            'metadata' => [
                'patient_id' => Auth::user()->patient->id,
                'psychologist_id' => $psychologist->id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'notes' => $request->notes ?? '',
            ],
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        // Configuration de clé secrète qui est dans .env 
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = Session::retrieve($request->get('session_id'));

        if (! $session) {
            return redirect()->route('patient.dashboard')->with('error', 'Paiement Error .');
        }
        // cree le rendez vous
        $appointment = Appointment::create([
            'patient_id' => $session->metadata->patient_id,
            'psychologist_id' => $session->metadata->psychologist_id,
            'appointmentDate' => $session->metadata->appointment_date,
            'appointmentTime' => $session->metadata->appointment_time,
            'status' => 'pending',
            'notes' => $session->metadata->notes,
        ]);
        // cree le paiement
        Payment::create([
            'appointment_id' => $appointment->id,
            'stripe_id' => $session->payment_intent,
            'totalPrice' => $session->amount_total / 100,
            'paymentDate' => now(),
            'status' => 'completed',
        ]);

        return redirect()->route('patient.rendezVous')->with('success', 'Paiement réussi ! Votre réservation est enregistrée et en attente de confirmation.');
    }

    public function cancel()
    {
        return redirect()->route('patient.reservation')->with('error', 'Le paiement a été annulé.');
    }
}
