<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Psychologist;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $appointmentsCount = $user->appointments()->count();
        
        $nextAppointment = $user->appointments()
            ->with('psychologist.user')
            ->where('appointmentDate', '>=', now()->toDateString())
            ->orderBy('appointmentDate')
            ->orderBy('appointmentTime')
            ->first();

        return view("patient.dashboard", compact('appointmentsCount', 'nextAppointment'));
    }
    public function reservation()
    {
        $psychologues = Psychologist::with('user')->where('validationStatus', 'approved')->get();
        return view("patient.reservation", compact('psychologues'));
    }
    public function rendezVous()
    {
        $user = Auth::user();
        $appointments = $user->appointments()
            ->with('psychologist.user')
            ->orderBy('appointmentDate', 'desc')
            ->orderBy('appointmentTime', 'desc')
            ->get();

        return view("patient.rendezVous", compact('appointments'));
    }
    public function profil(){
        return view("patient.profil");
    }
}
