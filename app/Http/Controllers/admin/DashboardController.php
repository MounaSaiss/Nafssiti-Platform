<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Psychologist;

class DashboardController extends Controller
{
    public function index(){
        $approvedPsychologists = Psychologist::with('user')->where('validationStatus', 'approved')->get();
        $pendingPsychologists = Psychologist::with('user')->where('validationStatus', 'pending')->get();
        $appointments = Appointment::all();
        $globalRevenue = 0;
        foreach ($approvedPsychologists as $psychologist) {
            $globalRevenue += $psychologist->pricePerSession * 0.1;
        }
        $activeUsersCount = User::where('status', 'actif')->where('role_id', '!=', 3)->count();
        return view('admin.dashboard', [
            'activeUsersCount' => $activeUsersCount,
            'psychologists' => $pendingPsychologists,
            'totalPsychologistsCount' => $approvedPsychologists->count(),
            'appointments' => $appointments,
            'globalRevenue' => $globalRevenue
        ]);
    }
    public function approvePsychologist($id){
        $psychologist = Psychologist::findOrFail($id);
        $psychologist->validationStatus = 'approved';
        $psychologist->save();
        
        // Update user status
        $psychologist->user->update(['status' => 'actif']);
        
        return redirect()->route('admin.dashboard')->with('success', 'Praticien approuvé avec succès.');
    }   
    public function rejectPsychologist($id){
        $psychologist = Psychologist::findOrFail($id);
        $user = $psychologist->user;
        
        // Explicitly delete both to avoid orphaned records in some environments
        $psychologist->delete();
        if ($user) {
            $user->delete();
        }
        
        return redirect()->route('admin.dashboard')->with('success', 'Praticien refusé et supprimé.');
    }
}

