<?php

namespace App\Http\Controllers\psychologue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Availability;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AvailabilityController extends Controller
{
    public function disponabilite()
    {
        $user = Auth::user();
        $psychologue = $user->psychologist;
        
        $availabilities = $psychologue->availabilities()
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function($val) {
                return Carbon::parse($val->date)->translatedFormat('l');
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
}
