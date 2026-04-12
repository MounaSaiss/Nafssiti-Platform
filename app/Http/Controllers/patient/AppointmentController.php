<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\patient\PatientAppointmentsFilterRequest;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function rendezVous(PatientAppointmentsFilterRequest $request)
    {
        $user = Auth::user();
        $statusFilter = $request->input('status', 'à-venir');
        
        $query = $user->appointments()->with('psychologist.user');

        if ($statusFilter === 'à-venir') {
            $query->where('status', 'confirmed')
                  ->where(function($q) {
                      $q->where('appointmentDate', '>', Carbon::today()->toDateString())
                        ->orWhere(function($sq) {
                            $sq->where('appointmentDate', '=', Carbon::today()->toDateString())
                               ->where('appointmentTime', '>=', Carbon::now()->toTimeString());
                        });
                  });
        } elseif ($statusFilter === 'en-attente') {
            $query->where('status', 'pending');
        } elseif ($statusFilter === 'refuse') {
            $query->where('status', 'rejected');
        }

        $appointments = $query->orderBy('appointmentDate', $statusFilter === 'refuse' ? 'desc' : 'asc')
            ->orderBy('appointmentTime', $statusFilter === 'refuse' ? 'desc' : 'asc')
            ->get();

        return view("patient.rendezVous", compact('appointments', 'statusFilter'));
    }
}
