<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Psychologist;
use App\Models\User;
use App\Models\Certificate;
use App\Http\Requests\patient\PatientRegisterRequest;
use App\Http\Requests\psychologue\PsychologueRegisterRequest;
use App\Http\Requests\auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showPatientRegistrationForm()
    {
        return view('auth.register.patient');
    }

    public function showPsychologueRegistrationForm()
    {
        return view('auth.register.psychologue');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function registerPatient(PatientRegisterRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $validated['password'],
            'role_id' => 1,
        ]);
        Patient::create([
            'user_id' => $user->id,
        ]);
        return redirect()->route('show.login')->with('success', 'Votre compte a été créé avec succès. Veuillez attendre la validation de l\'admin avant de vous connecter.');
    }
    public function registerPsychologue(PsychologueRegisterRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $validated['role_id'] = 2;

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $validated['password'],
            'avatar' => $avatarPath,
            'role_id' => $validated['role_id'],
        ]);

        $psychologist = Psychologist::create([
            'user_id' => $user->id,
            'specialization' => $validated['specialization'],
            'city' => $validated['city'],
            'experienceYears' => $validated['experienceYears'],
            'pricePerSession' => $validated['pricePerSession'],
            'consultationType' => $validated['consultationType'],
        ]);

        if ($request->hasFile('certificate_files')) {
            foreach ($request->file('certificate_files') as $file) {
                if ($file) {
                    $path = $file->store('certificates', 'public');
                    Certificate::create([
                        'psychologist_id' => $psychologist->id,
                        'type' => 'file',
                        'path_or_url' => $path,
                    ]);
                }
            }
        }

        if ($request->has('certificate_links') && is_array($request->input('certificate_links'))) {
            foreach ($request->input('certificate_links') as $link) {
                if (!empty($link)) {
                    Certificate::create([
                        'psychologist_id' => $psychologist->id,
                        'type' => 'link',
                        'path_or_url' => $link,
                    ]);
                }
            }
        }

        return redirect()->route('show.login')->with('success', 'Votre compte praticien a été créé. Veuillez attendre la validation de l\'admin.');
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        if (Auth::attempt($validated)) {
            $user = Auth::user();
            if ($user->status !== 'actif' ) {
                $statusMessage = $user->status === 'banni'
                    ? 'Votre compte a été banni.'
                    : 'Votre compte est en attente de validation par l\'admin';

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->back()->withErrors([
                    'auth_error' => $statusMessage,
                ]);
            }

            $request->session()->regenerate();

            $roleId = $user->role_id;

            if ($roleId == 1) {
                return redirect()->route('patient.dashboard');
            } elseif ($roleId == 2) {
                return redirect()->route('psychologue.dashboard');
            } elseif ($roleId == 3) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');
        } else {

            return redirect()->back()->withErrors([
                'auth_error' => 'Email ou mot de passe incorrect',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
