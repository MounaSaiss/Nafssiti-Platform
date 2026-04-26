<?php

namespace App\Http\Controllers\psychologue;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\FollowRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $psychologue = Auth::user()->psychologist;
        $today = Carbon::today()->toDateString();

        $totalAppointments = Appointment::where('psychologist_id', $psychologue->id)
            ->whereIn('status', ['confirmed', 'completed'])
            ->count();

        $appointmentsToday = Appointment::where('psychologist_id', $psychologue->id)
            ->where('appointmentDate', $today)
            ->whereIn('status', ['confirmed', 'completed'])
            ->count();

        $pastAppointments = Appointment::where('psychologist_id', $psychologue->id)
            ->whereIn('status', ['confirmed', 'completed'])
            ->where(function ($query) use ($today) {
                $query->where('appointmentDate', '<', $today)
                    ->orWhere('status', 'completed');
            })
            ->count();

        // Eager load 'patient.user' to avoid N+1 queries in the view
        $upcomingAppointments = Appointment::where('psychologist_id', $psychologue->id)
            ->with('patient.user')
            ->where('appointmentDate', '>=', $today)
            ->where('status', 'confirmed')
            ->orderBy('appointmentDate')
            ->orderBy('appointmentTime')
            ->take(5)
            ->get();

        // Retrieve followed patients efficiently
        $followedPatients = FollowRequest::where('psychologist_id', $psychologue->id)
            ->where('status', 'accepted')
            ->with('patient.user')
            ->get()
            ->pluck('patient');

        return view('psychologue.dashboard', compact(
            'totalAppointments',
            'appointmentsToday',
            'pastAppointments',
            'upcomingAppointments',
            'followedPatients'
        ));
    }
}
