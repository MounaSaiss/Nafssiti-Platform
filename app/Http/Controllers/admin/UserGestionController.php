<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\UserFilterRequest;
use App\Models\User;

class UserGestionController extends Controller
{
    public function userGestion(UserFilterRequest $request)
    {
        $roleFilter = $request->query('role');
        $search = $request->query('search');

        $query = User::query();

        if ($roleFilter === 'patient') {
            $query->where('role_id', 1);
        } elseif ($roleFilter === 'psychologue') {
            $query->where('role_id', 2);
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

        $users = $query->get();
        return view('admin.userGestion', compact('users'));
    }
    public function banUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->isAdmin()) {
            return redirect()->route('admin.userGestion')->with('error', 'Impossible de bannir un administrateur.');
        }
        $user->status = 'banni';
        $user->save();
        return redirect()->route('admin.userGestion')->with('success', 'Utilisateur banni avec succès.');
    }
    public function unbanUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->isAdmin()) {
            return redirect()->route('admin.userGestion')->with('error', 'Impossible de modifier le statut d\'un administrateur.');
        }
        $user->status = 'actif';
        $user->save();
        return redirect()->route('admin.userGestion')->with('success', 'Utilisateur activé avec succès.');
    }
}
