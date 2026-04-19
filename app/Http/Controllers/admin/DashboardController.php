<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Psychologist;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $approvedPsychologists = Psychologist::with('user')->where('validationStatus', 'approved')->get();
        $pendingPsychologists = Psychologist::with('user')->where('validationStatus', 'pending')->get();
        $appointments = Appointment::all();
        $globalRevenue = 0;
        $globalRevenue = Payment::where('status', 'completed')->sum('totalPrice') * 0.1;
        $activeUsersCount = User::where('status', 'actif')->where('role_id', '!=', 3)->count();

        return view('admin.dashboard', [
            'activeUsersCount' => $activeUsersCount,
            'psychologists' => $pendingPsychologists,
            'totalPsychologistsCount' => $approvedPsychologists->count(),
            'appointments' => $appointments,
            'globalRevenue' => $globalRevenue,
        ]);
    }
}
