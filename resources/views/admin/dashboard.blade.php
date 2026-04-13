@extends('admin.layouts.app')

@section('title', 'Console Administration | NAFSSITI')

@section('page_title', 'Tableau de bord')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-5 border border-slate-200 shadow-sm rounded-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Utilisateurs actifs</p>
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">{{ $activeUsersCount }}</h3>
                </div>
                <div class="p-2 bg-slate-50 rounded border border-slate-100 text-nafssiti-primary">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 border border-slate-200 shadow-sm rounded-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Psychologues</p>
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">{{ $totalPsychologistsCount }}</h3>
                </div>
                <div class="p-2 bg-slate-50 rounded border border-slate-100 text-nafssiti-secondary">
                    <i class="fas fa-user-md"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 border border-slate-200 shadow-sm rounded-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Rendez-vous</p>
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">{{ $appointments->count() }}</h3>
                </div>
                <div class="p-2 bg-slate-50 rounded border border-slate-100 text-slate-800">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 border border-slate-200 shadow-sm rounded-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Revenu Global</p>
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">{{ number_format($globalRevenue, 2) }} <span
                            class="text-sm font-normal">DH</span>
                    </h3>
                </div>
                <div class="p-2 bg-slate-50 rounded border border-slate-100 text-nafssiti-primary">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-800 uppercase tracking-widest text-sm italic">Validation des nouveaux praticiens</h3>
                <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-tighter">Une fois validé, le psychologue apparaît dans la liste suivante et peut être géré via la page <a href="{{ route('admin.users.index') }}" class="text-nafssiti-primary hover:underline">Utilisateurs</a>.</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase tracking-tight">
                        <th class="px-6 py-4 font-bold border-b border-slate-200">ID</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200">Praticien</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200">Spécialité</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200 text-center">Ville</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($psychologists as $psychologist)
                        <tr>
                            <td class="px-6 py-4 font-mono text-slate-400">{{ $psychologist->id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $psychologist->user->avatar ? asset('storage/' . $psychologist->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($psychologist->user->name ?? 'P') . '&background=4dbfbf&color=fff' }}" 
                                         class="w-8 h-8 rounded-full border border-slate-200 object-cover shadow-sm">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 uppercase leading-none">{{ $psychologist->user->name ?? 'Praticien inconnu' }}</span>
                                        <span class="text-slate-400 font-light tracking-tight text-[10px] mt-1">{{ $psychologist->user->email ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $psychologist->specialization }}</td>
                            <td class="px-6 py-4">{{ $psychologist->city }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.users.approve', $psychologist->user) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-1.5 bg-green-50 text-green-600 border border-green-100 rounded-sm text-[9px] font-bold uppercase tracking-wider hover:bg-green-600 hover:text-white hover:border-green-600 transition-all shadow-sm">
                                            Valide
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.reject', $psychologist->user) }}" method="POST" onsubmit="return confirm('Refuser ce praticien ?')">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-1.5 bg-red-50 text-red-500 border border-red-100 rounded-sm text-[9px] font-bold uppercase tracking-wider hover:bg-red-600 hover:text-white hover:border-red-600 transition-all shadow-sm">
                                            Invalide
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">
                                Aucun nouveau praticien en attente de validation.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
