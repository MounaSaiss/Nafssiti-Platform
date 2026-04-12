<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\patient\StoreReservationRequest;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Psychologist;
use App\Models\Unavailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Carbon\Carbon;

class StripePaymentController extends Controller
{
    public function checkout(StoreReservationRequest $request)
    {
        $psychologist_id = $request->psychologist_id;
        $appointmentDate = $request->appointment_date;
        $appointmentTime = $request->appointment_time;

        // --- DEBUT VALIDATION (Copiée de ReservationController) ---
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

        // Check availability
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
        // --- FIN VALIDATION ---

        $psychologist = Psychologist::findOrFail($psychologist_id);
        $amount = ($psychologist->pricePerSession ?? 50) * 100; // Default 50 if null

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur', // Or 'mad'
                    'product_data' => [
                        'name' => 'Consultation avec Dr. ' . $psychologist->user->name,
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('patient.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('patient.payment.cancel'),
            'metadata' => [
                'patient_id' => Auth::user()->patient->id,
                'psychologist_id' => $psychologist->id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'notes' => $request->notes ?? '',
            ]
        ]);

        return redirect($checkout_session->url);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = Session::retrieve($request->get('session_id'));

        if (!$session) {
            return redirect()->route('patient.dashboard')->with('error', 'Erreur de paiement.');
        }

        // 1. Create the Appointment
        $appointment = Appointment::create([
            'patient_id' => $session->metadata->patient_id,
            'psychologist_id' => $session->metadata->psychologist_id,
            'appointmentDate' => $session->metadata->appointment_date,
            'appointmentTime' => $session->metadata->appointment_time,
            'status' => 'pending',
            'notes' => $session->metadata->notes,
        ]);

        // 2. Create the Payment Record
        Payment::create([
            'appointment_id' => $appointment->id,
            'user_id' => Auth::id(),
            'stripe_id' => $session->payment_intent, // Save PaymentIntent ID for refunds
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
