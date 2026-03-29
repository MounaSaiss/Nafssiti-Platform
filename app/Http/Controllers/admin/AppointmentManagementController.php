<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\AppointmentsFilterRequest;
use App\Models\Appointment;

class AppointmentManagementController extends Controller
{
    public function index(AppointmentsFilterRequest $request)
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

        if (isset($request->status) && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        $appointments = $query->latest()->get();
        return view('admin.appointmentManagement', compact('appointments'));
    }
    public function accept(Appointment $appointment)
    {
        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Ce rendez-vous n\'est plus en attente.');
        }

        $appointment->update(['status' => 'confirmed']);

        return back()->with('success', 'Le rendez-vous a été accepté avec succès.');
    }
    public function refuse(Appointment $appointment)
    {
        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Ce rendez-vous n\'est plus en attente.');
        }

        $appointment->update(['status' => 'rejected']);

        return back()->with('success', 'Le rendez-vous a été refusé.');
    }
}
