<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $appointmentsCount = $user->appointments()
            ->whereIn('status', ['confirmed', 'completed'])
            ->count();

        $nextAppointment = $user->appointments()
            ->with('psychologist.user')
            ->where('status', 'confirmed')
            ->where(function ($q) {
                $q->where('appointmentDate', '>', now()->toDateString())
                    ->orWhere(function ($sq) {
                        $sq->where('appointmentDate', '=', now()->toDateString())
                            ->where('appointmentTime', '>=', now()->toTimeString());
                    });
            })
            ->orderBy('appointmentDate')
            ->orderBy('appointmentTime')
            ->first();

        return view('patient.dashboard', compact('appointmentsCount', 'nextAppointment'));
    }
}
