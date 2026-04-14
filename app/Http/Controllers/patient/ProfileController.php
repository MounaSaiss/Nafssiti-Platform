<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\patient\UpdatePatientProfilRequest;

class ProfileController extends Controller
{
    public function profil()
    {
        return view("patient.profil");
    }

    public function updateProfil(UpdatePatientProfilRequest $request)
    {
        $user = Auth::user();
        
        $validated = $request->validated();

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }
        $user->update($data);

        return redirect()->back()->with('success', 'Votre profil a été mis à jour avec succès.');
    }
}
