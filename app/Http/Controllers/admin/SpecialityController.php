<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StoreSpecialityRequest;
use App\Models\Speciality;

class SpecialityController extends Controller
{
    public function index()
    {
        $specialities = Speciality::all();
        return view('admin.specialities', compact('specialities'));
    }

    public function store(StoreSpecialityRequest $request)
    {
        Speciality::create($request->validated());

        return redirect()->back()->with('success', 'Spécialité ajoutée avec succès.');
    }

    public function destroy($id)
    {
        $speciality = Speciality::findOrFail($id);
        $speciality->delete();

        return redirect()->back()->with('success', 'Spécialité supprimée avec succès.');
    }
}
