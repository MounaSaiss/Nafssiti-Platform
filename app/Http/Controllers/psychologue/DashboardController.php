<?php

namespace App\Http\Controllers\psychologue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Availability;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        return view("psychologue.dashboard");
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
    public function rendezVous(){
        return view("psychologue.rendezVous");
    }
    public function historique(){
        return view("psychologue.historique");
    }
}
