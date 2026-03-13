@extends('admin.layouts.app')

@section('title', 'Gestion Utilisateurs | NAFSSITI PRO')

@section('page_title', 'Annuaire Utilisateurs')

@section('header_actions')
    <div class="flex items-center gap-4">
        <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded font-bold uppercase tracking-widest">Total
            : {{ $users->count() }}</span>
    </div>
@endsection

@section('content')
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-sm text-sm font-medium flex items-center gap-3">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-sm text-sm font-medium flex items-center gap-3">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
    @endif


    <form action="{{ route('admin.userGestion') }}" method="GET" class="flex flex-col md:flex-row gap-4 mb-6">
        <div class="relative flex-1">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom, email, ville..."
                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded shadow-sm text-sm focus:ring-1 focus:ring-nafssiti-primary outline-none transition">
        </div>
        <select name="role" onchange="this.form.submit()"
            class="bg-white border border-slate-200 px-4 py-2.5 rounded text-xs font-bold uppercase tracking-tight text-slate-600 outline-none cursor-pointer">
            <option value="all" {{ request('role') == 'all' || !request('role') ? 'selected' : '' }}>Tous les rôles</option>
            <option value="patient" {{ request('role') == 'patient' ? 'selected' : '' }}>Patients</option>
            <option value="psychologue" {{ request('role') == 'psychologue' ? 'selected' : '' }}>Psychologues</option>
        </select>
    </form>

    <div class="bg-white border border-slate-200 shadow-sm rounded-sm overflow-hidden">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 uppercase tracking-widest border-b border-slate-200">
                    <th class="px-6 py-4 font-bold">Utilisateur</th>
                    <th class="px-6 py-4 font-bold">Rôle</th>
                    <th class="px-6 py-4 font-bold">Ville</th>
                    <th class="px-6 py-4 font-bold text-center">Statut</th>
                    <th class="px-6 py-4 font-bold text-right">Actions de Contrôle</th>
                </tr>
            </thead>
            @foreach ($users as $user)
                @if($user->role_id != 3)
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=4dbfbf&color=fff"
                                    class="w-8 h-8 rounded-full shadow-sm">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-900 uppercase tracking-tight">{{ $user->name }}</span>
                                    <span class="text-slate-400 text-[10px]">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="text-[10px] font-bold text-slate-500 border border-slate-200 px-2 py-0.5 rounded uppercase">{{ $user->role->status }}</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-700">
                            @if($user->psychologist)
                                {{ $user->psychologist->city }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->status == 'actif')
                            <span class="inline-flex items-center gap-1.5 text-green-600 font-bold uppercase text-[9px] bg-green-50 px-2 py-1 rounded border border-green-100">
                                {{ $user->status }}
                            </span>
                            @elseif($user->status == 'banni')
                            <span class="inline-flex items-center gap-1.5 text-red-600 font-bold uppercase text-[9px] bg-red-50 px-2 py-1 rounded border border-red-100">
                                {{ $user->status }}
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 text-amber-600 font-bold uppercase text-[9px] bg-amber-50 px-2 py-1 rounded border border-amber-100">
                                {{ $user->status }}
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2 items-center">
                                @if($user->isAdmin())
                                    <button disabled
                                        class="flex items-center justify-center gap-2 px-3 py-2 bg-slate-50 text-slate-400 rounded-sm font-bold uppercase text-[10px] border border-slate-200 cursor-not-allowed">
                                        <i class="fas fa-shield-alt"></i> Protégé
                                    </button>
                                @else
                                    <button
                                        class="flex items-center justify-center gap-2 px-3 py-2 bg-slate-100 text-slate-700 rounded-sm font-bold uppercase text-[10px] hover:bg-slate-200 transition-all border border-slate-200 shadow-sm">
                                        <i class="fas fa-eye"></i> Consulter
                                    </button>
                                    @if($user->status != 'actif')
                                    <form action="{{ route('admin.unbanUser', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-28 flex items-center justify-center gap-2 px-3 py-2 bg-white text-nafssiti-primary border border-nafssiti-primary rounded-sm font-bold uppercase text-[10px] hover:bg-nafssiti-primary hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-check"></i> Activer
                                        </button>
                                    </form>
                                    @endif
                                    @if($user->status != 'banni')
                                    <form action="{{ route('admin.banUser', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-28 flex items-center justify-center gap-2 px-3 py-2 bg-white text-nafssiti-red border border-nafssiti-red rounded-sm font-bold uppercase text-[10px] hover:bg-nafssiti-red hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-ban"></i> Bannir
                                        </button>
                                    </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                </tbody>
                @endif
            @endforeach
        </table>
    </div>
@endsection
