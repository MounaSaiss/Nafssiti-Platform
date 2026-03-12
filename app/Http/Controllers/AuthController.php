<?php

namespace App\Http\Controllers;

use App\Models\Psychologist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\patient;

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

    public function registerPatient(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required',
            'password' => 'required|string|min:8',
        ]);
        $validated['password'] = bcrypt($validated['password']);
        $validated['role_id'] = 1;

        $user = User::create($validated);
        patient::create([
            'user_id' => $user->id,
        ]);

        return redirect()->route('show.login')->with('success', 'Votre compte a été créé avec succès. Veuillez attendre la validation de l\'administrateur avant de vous connecter.');
    }

    public function registerPsychologue(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required',
            'password' => 'required|string|min:8',

            'specialization' => 'required|string|max:255',
            'city' => 'required|string',
            'experienceYears' => 'required|integer',
            'pricePerSession' => 'required|numeric',
            'consultationType' => 'required|string',
            'certificate' => 'nullable|file',
            'photo' => 'nullable|image',
        ]);
        $validated['password'] = bcrypt($validated['password']);
        $validated['role_id'] = 2;

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $validated['password'],
            'role_id' => $validated['role_id'],
        ]);

        $certificatePath = $request->file('certificate')?->store('certificates', 'public');
        $photoPath = $request->file('photo')?->store('psychologists', 'public');

        Psychologist::create([
            'user_id' => $user->id,
            'specialization' => $validated['specialization'],
            'city' => $validated['city'],
            'experienceYears' => $validated['experienceYears'],
            'pricePerSession' => $validated['pricePerSession'],
            'consultationType' => $validated['consultationType'],
            'certificate' => $certificatePath,
            'photo' => $photoPath,
        ]);
        return redirect()->route('show.login')->with('success', 'Votre compte praticien a été créé. Veuillez attendre la validation de l\'administrateur.');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->status !== 'actif') {
                $statusMessage = $user->status === 'banni' 
                    ? 'Votre compte a été banni.' 
                    : 'Votre compte est en attente de validation par l\'administrateur.';

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->back()->withErrors([
                    'credentials' => $statusMessage,
                ]);
            }

            $request->session()->regenerate();

            $roleId = $user->role_id;

            if ($roleId == 1) {
                return redirect('/patient/dashboard');
            } elseif ($roleId == 2) {
                return redirect('/psychologue/dashboard');
            } elseif ($roleId == 3) {
                return redirect('/admin/dashboard');
            }

            return redirect()->route('home');
        }

        return redirect()->back()->withErrors([
            'credentials' => 'Email ou mot de passe incorrect',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
