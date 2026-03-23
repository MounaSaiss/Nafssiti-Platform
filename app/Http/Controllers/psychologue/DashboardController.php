<?php

namespace App\Http\Controllers\psychologue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Availability;
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
    public function profil(){
        return view("psychologue.profil");
    }
    public function disponabilite()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $psychologue = $user->psychologist;
        
        $availabilities = $psychologue->availabilities()
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function($val) {
                return \Carbon\Carbon::parse($val->date)->translatedFormat('l');
            });

        return view("psychologue.disponabilite", compact('availabilities'));
    }

    public function storeDisponabilite(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $user = Auth::user();
        $psychologue = $user->psychologist;

        // Prevent past time slots for today
        $now = Carbon::now();
        if ($request->date == $now->toDateString()) {
            if ($request->start_time <= $now->toTimeString()) {
                return redirect()->back()->with('error', 'Vous ne pouvez pas ajouter un créneau dans le passé pour aujourd\'hui.');
            }
        }

        // Check for overlap
        $overlap = Availability::where('psychologist_id', $psychologue->id)
            ->where('date', $request->date)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>', $request->start_time);
                });
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()->with('error', 'Vous avez déjà un créneau qui chevauche cet horaire.');
        }

        Availability::create([
            'psychologist_id' => $psychologue->id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with('success', 'Créneau ajouté avec succès.');
    }

    public function destroyDisponabilite($id)
    {
        $user = Auth::user();
        $psychologue = $user->psychologist;

        $availability = Availability::where('id', $id)
            ->where('psychologist_id', $psychologue->id)
            ->firstOrFail();

        $availability->delete();

        return redirect()->back()->with('success', 'Créneau supprimé avec succès.');
    }
    public function rendezVous(Request $request)
    {
        $user = Auth::user();
        $psychologue = $user->psychologist;
        $filter = $request->get('filter', 'all');

        $query = Appointment::where('psychologist_id', $psychologue->id);

        if ($filter === 'upcoming') {
            $query->where('status', 'confirmed')
                  ->where('appointmentDate', '>=', Carbon::today()->toDateString());
        } elseif ($filter === 'pending') {
            $query->where('status', 'pending');
        } else {
            $query->whereIn('status', ['pending', 'confirmed', 'rejected', 'completed']);
        }

        $appointments = $query->orderBy('appointmentDate', 'desc')
            ->orderBy('appointmentTime', 'desc')
            ->get();

        return view("psychologue.rendezVous", compact('appointments', 'filter'));
    }
    public function historique()
    {
        $user = Auth::user();
        $psychologue = $user->psychologist;

        $appointments = Appointment::where('psychologist_id', $psychologue->id)
            ->where('status', 'confirmed')
            ->where(function ($query) {
                $query->where('appointmentDate', '<', Carbon::today()->toDateString())
                      ->orWhere(function ($q) {
                          $q->where('appointmentDate', '=', Carbon::today()->toDateString())
                            ->where('appointmentTime', '<', Carbon::now()->toTimeString());
                      });
            })
            ->with('patient.user')
            ->orderBy('appointmentDate', 'desc')
            ->orderBy('appointmentTime', 'desc')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->appointmentDate)->translatedFormat('F Y');
            });

        return view("psychologue.historique", compact('appointments'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $psychologue = $user->psychologist;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'experienceYears' => 'required|integer',
            'description' => 'nullable|string',
            'education' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->update([
            'name' => $validated['name'],
            'city' => $validated['city'], // Update both just in case
        ]);

        if ($request->hasFile('avatar')) {
            if ($psychologue->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($psychologue->photo);
            }
            $psychologue->photo = $request->file('avatar')->store('psychologists', 'public');
        }

        $psychologue->update([
            'specialization' => $validated['specialization'],
            'city' => $validated['city'],
            'experienceYears' => $validated['experienceYears'],
            'description' => $validated['description'] ?? $psychologue->description,
            'education' => $validated['education'] ?? $psychologue->education,
        ]);

        return redirect()->back()->with('success', 'Votre profil professionnel a été mis à jour.');
    }
}
