<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Psychologist;

class DashboardController extends Controller
{
    public function index(){
        $users = User::all();
        $allPsychologists = Psychologist::all();
        $pendingPsychologists = Psychologist::where('validationStatus', 'pending')->get();
        $appointments = Appointment::all();
        $globalRevenue = 0;
        foreach ($allPsychologists as $psychologist) {
            $globalRevenue += $psychologist->pricePerSession * 0.1;
        }
        $activeUsersCount = User::where('status', 'actif')->where('role_id', '!=', 3)->count();
        return view('admin.dashboard', [
            'users' => $users,
            'activeUsersCount' => $activeUsersCount,
            'psychologists' => $pendingPsychologists,
            'totalPsychologistsCount' => $allPsychologists->count(),
            'appointments' => $appointments,
            'globalRevenue' => $globalRevenue
        ]);
    }
    public function approvePsychologist($id){
        $psychologist = Psychologist::findOrFail($id);
        $psychologist->validationStatus = 'approved';
        $psychologist->save();
        return redirect()->route('admin.dashboard');
    }   
    public function rejectPsychologist($id){
        $psychologist = Psychologist::findOrFail($id);
        $psychologist->validationStatus = 'rejected';
        $psychologist->save();
        return redirect()->route('admin.dashboard');
    }
}

