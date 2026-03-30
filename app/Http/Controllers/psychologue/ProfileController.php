<?php

namespace App\Http\Controllers\psychologue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function profil()
    {
        return view("psychologue.profil");
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
            'city' => $validated['city'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($psychologue->photo) {
                Storage::disk('public')->delete($psychologue->photo);
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
