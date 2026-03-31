<?php

namespace App\Http\Controllers\psychologue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function rendezVous(Request $request)
    {
        $user = Auth::user();
        $psychologue = $user->psychologist;
        $filter = $request->input('filter', 'all');

        $query = Appointment::where('psychologist_id', $psychologue->id);

        if ($filter === 'upcoming') {
            $query->where('status', 'confirmed')
                  ->where('appointmentDate', '>=', Carbon::today()->toDateString());
        } elseif ($filter === 'pending') {
            $query->where('status', 'pending');
        } else {
            $query->whereIn('status', ['pending', 'confirmed', 'rejected', 'completed']);
        }

        $appointments = $query->orderBy('appointmentDate', 'desc')
            ->orderBy('appointmentTime', 'desc')
            ->get();

        return view("psychologue.rendezVous", compact('appointments', 'filter'));
    }

    public function historique()
    {
        $user = Auth::user();
        $psychologue = $user->psychologist;

        $appointments = Appointment::where('psychologist_id', $psychologue->id)
            ->where('status', 'confirmed')
            ->where(function ($query) {
                $query->where('appointmentDate', '<', Carbon::today()->toDateString())
                      ->orWhere(function ($q) {
                          $q->where('appointmentDate', '=', Carbon::today()->toDateString())
                            ->where('appointmentTime', '<', Carbon::now()->toTimeString());
                      });
            })
            ->with('patient.user')
            ->orderBy('appointmentDate', 'desc')
            ->orderBy('appointmentTime', 'desc')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->appointmentDate)->translatedFormat('F Y');
            });

        return view("psychologue.historique", compact('appointments'));
    }
}
