<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
    public function reservation(){
        return view("patient.reservation");
    }
    public function rendezVous(){
        return view("patient.rendezVous");
    }
    public function profil(){
        return view("patient.profil");
    }
}
