<?php

namespace App\Http\Controllers\psychologue;

use App\Http\Requests\psychologue\StoreUnavailabilityRequest;
use App\Http\Controllers\Controller;
use App\Models\Unavailability;
use Illuminate\Support\Facades\Auth;

class UnavailabilityController extends Controller
{
    public function indisponabilite()
    {
        $user = Auth::user();
        $psychologue = $user->psychologist;
        
        $unavailabilities = $psychologue->unavailabilities()
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy('date');

        return view("psychologue.disponabilite", compact('unavailabilities'));
    }

    public function storeIndisponabilite(StoreUnavailabilityRequest $request)
    {
        $user = Auth::user();
        $psychologue = $user->psychologist;

        // Check for overlaps in unavailabilities
        $existe = Unavailability::where('psychologist_id', $psychologue->id)
            ->where('date', $request->date)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>', $request->start_time);
                });
            })
            ->exists();

        if ($existe) {
            return redirect()->back()->with('error', 'Cet horaire est déjà marqué comme indisponible.');
        }

        Unavailability::create([
            'psychologist_id' => $psychologue->id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with('success', 'Période d\'indisponibilité ajoutée avec succès.');
    }

    public function destroyIndisponabilite($id)
    {
        $user = Auth::user();
        $psychologue = $user->psychologist;

        $unavailability = Unavailability::where('id', $id)
            ->where('psychologist_id', $psychologue->id)
            ->firstOrFail();

        $unavailability->delete();

        return redirect()->back()->with('delete_success', 'L\'indisponibilité a été supprimée. Vous êtes de nouveau disponible sur ce créneau.');
    }
}
