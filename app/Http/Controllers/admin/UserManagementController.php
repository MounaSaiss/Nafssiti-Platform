<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\UserFilterRequest;
use App\Models\User;

class UserManagementController extends Controller
{
    public function index(UserFilterRequest $request)
    {
        $roleFilter = $request->query('role');
        $search = $request->query('search');

        $query = User::whereNot(function ($q) {
            $q->where('role_id', User::ROLE_PSYCHOLOGUE)
              ->where('status', User::STATUS_EN_ATTENTE);
        });

        if ($roleFilter && $roleFilter !== 'all') {
            $roleId = match($roleFilter) {
                'patient' => User::ROLE_PATIENT,
                'psychologue' => User::ROLE_PSYCHOLOGUE,
                default => null,
            };

            if ($roleId) {
                $query->where('role_id', $roleId);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('psychologist', function ($pq) use ($search) {
                        $pq->where('city', 'like', "%{$search}%");
                    });
            });
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
        if (!$user->isPsychologue() || $user->status !== User::STATUS_EN_ATTENTE) {
            return back()->with('error', 'Cet utilisateur ne peut pas être approuvé.');
        }

        $user->update(['status' => User::STATUS_ACTIF]);

        if ($user->psychologist) {
            $user->psychologist->update(['validationStatus' => 'approved']);
        }

        return back()->with('success', 'Psychologue approuvé avec succès.');
    }

    public function reject(User $user)
    {
        if (!$user->isPsychologue() || $user->status !== User::STATUS_EN_ATTENTE) {
            return back()->with('error', 'Cet utilisateur ne peut pas être rejeté.');
        }

        if ($user->psychologist) {
            $user->psychologist->delete();
        }
        
        $user->delete();

        return back()->with('success', 'Praticien rejeté et supprimé définitivement.');
    }
}
