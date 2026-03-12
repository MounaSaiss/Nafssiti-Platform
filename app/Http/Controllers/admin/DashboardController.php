<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Psychologist;

class DashboardController extends Controller
{
    public function index(){
        $users = User::all();
        $psychologists = Psychologist::all();
        $appointments = Appointment::all();
        $globalRevenue = 0;
        foreach ($psychologists as $psychologist) {
            $globalRevenue += $psychologist->pricePerSession * 0.1;
        }
        return view('admin.dashboard', compact('users', 'psychologists', 'appointments', 'globalRevenue'));
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

