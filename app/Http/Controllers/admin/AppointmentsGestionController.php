<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\AppointmentsFilterRequest;
use App\Models\Appointment;

class AppointmentsGestionController extends Controller
{
    public function appointmentsGestion(AppointmentsFilterRequest $request)
    {
        $query = Appointment::with(['patient.user', 'psychologist.user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('patient.user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })->orWhereHas('psychologist.user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $appointments = $query->latest()->get();
        return view('admin.appointmentsGestion', compact('appointments'));
    }

    public function acceptAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'confirmed';
        $appointment->save();

        return redirect()->back()->with('success', 'Le rendez-vous a été accepté avec succès.');
    }

    public function refuseAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'rejected';
        $appointment->save();

        return redirect()->back()->with('success', 'Le rendez-vous a été refusé.');
    }
}
