<?php

namespace App\Http\Controllers\psychologue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $psychologue = $user->psychologist;

        // Only count and show confirmed or completed appointments
        $visibleStatuses = ['confirmed', 'completed'];

        $totalAppointments = Appointment::where('psychologist_id', $psychologue->id)
            ->whereIn('status', $visibleStatuses)
            ->count();

        $appointmentsToday = Appointment::where('psychologist_id', $psychologue->id)
            ->where('appointmentDate', Carbon::today()->toDateString())
            ->whereIn('status', $visibleStatuses)
            ->count();

        $pastAppointments = Appointment::where('psychologist_id', $psychologue->id)
            ->where(function ($query) {
                $query->where('appointmentDate', '<', Carbon::today()->toDateString())
                    ->orWhere('status', 'completed');
            })
            ->whereIn('status', $visibleStatuses)
            ->count();

        $upcomingUpcoming = Appointment::where('psychologist_id', $psychologue->id)
            ->where('appointmentDate', '>=', Carbon::today()->toDateString())
            ->where('status', 'confirmed') // For dashboard preview, show only confirmed upcoming
            ->orderBy('appointmentDate')
            ->orderBy('appointmentTime')
            ->take(5)
            ->get();

        return view("psychologue.dashboard", compact(
            'totalAppointments',
            'appointmentsToday',
            'pastAppointments',
            'upcomingUpcoming'
        ));
    }
}
