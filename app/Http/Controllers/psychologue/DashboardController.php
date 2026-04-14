<?php

namespace App\Http\Controllers\psychologue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\FollowRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $psychologue = $user->psychologist;

        $totalAppointments = Appointment::where('psychologist_id', $psychologue->id)
            ->whereIn('status', ['confirmed', 'completed'])
            ->count();

        $appointmentsToday = Appointment::where('psychologist_id', $psychologue->id)
            ->where('appointmentDate', Carbon::today()->toDateString())
            ->whereIn('status', ['confirmed', 'completed'])
            ->count();

        $pastAppointments = Appointment::where('psychologist_id', $psychologue->id)
            ->where(function ($query) {
                $query->where('appointmentDate', '<', Carbon::today()->toDateString())
                    ->orWhere('status', 'completed');
            })
            ->whereIn('status', ['confirmed', 'completed'])
            ->count();

        $upcomingUpcoming = Appointment::where('psychologist_id', $psychologue->id)
            ->where('appointmentDate', '>=', Carbon::today()->toDateString())
            ->where('status', 'confirmed') 
            ->orderBy('appointmentDate')
            ->orderBy('appointmentTime')
            ->take(5)
            ->get();

        // Récupérer les patients suivis (FollowRequest accepted)
        $followedPatients = FollowRequest::where('psychologist_id', $psychologue->id)
            ->where('status', 'accepted')
            ->with('patient.user')
            ->get()
            ->map(function($request) {
                return $request->patient;
            });

        return view("psychologue.dashboard", compact(
            'totalAppointments',
            'appointmentsToday',
            'pastAppointments',
            'upcomingUpcoming',
            'followedPatients'
        ));
    }
}
