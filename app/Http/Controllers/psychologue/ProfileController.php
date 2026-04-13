<?php

namespace App\Http\Controllers\psychologue;

use App\Http\Requests\psychologue\UpdateProfileRequest;
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

    public function updateProfil(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $psychologue = $user->psychologist;

        $validated = $request->validated();

        $userData = [
            'name' => $validated['name'],
            'city' => $validated['city'],
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($userData);
        
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
