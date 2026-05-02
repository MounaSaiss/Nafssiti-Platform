<?php

namespace App\Http\Controllers;

use App\Models\Psychologist;
use App\Models\Speciality;
use Illuminate\Http\Request;

class PsychologueController extends Controller
{
    public function allPsychologues(Request $request)
    {
        $query = Psychologist::with('user')->where('validationStatus', 'approved');

        if ($request->filled('specialty')) {
            $query->where('specialization', $request->specialty);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $psychologues = $query->get();
        
        $cities = Psychologist::where('validationStatus', 'approved')
            ->distinct()
            ->pluck('city');
            
        $specialties = Psychologist::where('validationStatus', 'approved')
            ->distinct()
            ->pluck('specialization');

        return view('psychologue.allPsychologues', compact('psychologues', 'specialties', 'cities'));
    }
}
