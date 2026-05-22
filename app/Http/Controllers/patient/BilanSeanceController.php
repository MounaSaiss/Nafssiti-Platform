<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\FollowRequest;

class BilanSeanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->patient) {
            return view('patient.post_meeting', ['appointment' => null, 'followRequests' => collect()]);
        }

        $appointment = Appointment::with('psychologist.user')
            ->where('patient_id', $user->patient->id)
            ->where('status', 'confirmed')
            ->orderBy('appointmentDate', 'desc')
            ->orderBy('appointmentTime', 'desc')
            ->first();

        $followRequests = FollowRequest::with('psychologist.user')
        ->where('patient_id', $user->patient->id)
        ->orderBy('created_at', 'desc')
        ->get();

        // dd($followRequests);
        
        return view('patient.post_meeting', compact('appointment', 'followRequests'));
    }
}
