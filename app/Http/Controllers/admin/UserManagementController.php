<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\UserFilterRequest;
use App\Models\User;

class UserManagementController extends Controller
{
    public function index(UserFilterRequest $request)
    {
        // On exclut les admins et les psychologues en attente
        $query = User::where('role_id', '!=', User::ROLE_ADMIN)
             ->whereNot(fn($q) => $q->where('role_id', User::ROLE_PSYCHOLOGUE)->where('status', User::STATUS_EN_ATTENTE));

        // Filtre par rôle
        if ($request->role && $request->role !== 'all') {
             $query->where('role_id', $request->role === 'patient' ? User::ROLE_PATIENT : User::ROLE_PSYCHOLOGUE);
        }
        // Recherche
        if ($search = $request->search) {
            $query->where(fn($q) => 
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhereHas('psychologist', fn($pq) => $pq->where('city', 'like', "%$search%"))
            );
        }
        $users = $query->latest()->get();
        return view('admin.userManagement', compact('users'));
    }

    public function ban(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Impossible de bannir un admin.');
        }
        $user->update(['status' => User::STATUS_BANNI]);
        return back()->with('success', 'Utilisateur banni avec succès.');
    }

    public function unban(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Impossible de modifier le statut d\'un admin.');
        }
        $user->update(['status' => User::STATUS_ACTIF]);
        return back()->with('success', 'Utilisateur activé avec succès.');
    }
    
    public function approve(User $user)
    {
        if ($user->status !== User::STATUS_EN_ATTENTE || $user->isAdmin()) {
            return back()->with('error', 'Compte Protégé.');
        }
        $user->update(['status' => User::STATUS_ACTIF]);
        if ($user->psychologist) {
            $user->psychologist->update(['validationStatus' => 'approved']);
        }
        return back()->with('success', 'Utilisateur approuvé avec succès.');
    }

    public function reject(User $user)
    {
        if ($user->status !== User::STATUS_EN_ATTENTE || $user->isAdmin()) {
            return back()->with('error', 'Compte Protégé.');
        }
        if ($user->psychologist) {
            $user->psychologist->delete();
        }
        $user->delete();
        return back()->with('success', 'Utilisateur rejeté et supprimé définitivement.');
    }
}
