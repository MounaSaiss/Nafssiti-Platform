@extends('layouts.psychologue')

@section('title', 'Mes Rendez-vous | NAFSSITI Pro')
@section('header_title', 'Gestion des Séances')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex gap-2">
            <a href="{{ route('psychologue.rendezVous', ['filter' => 'all']) }}" 
               class="px-4 py-2 {{ $filter === 'all' ? 'bg-nafssiti-dark text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-400 hover:border-nafssiti-primary' }} text-[10px] font-bold uppercase tracking-wider rounded-sm transition">
                Tous
            </a>
            <a href="{{ route('psychologue.rendezVous', ['filter' => 'upcoming']) }}" 
               class="px-4 py-2 {{ $filter === 'upcoming' ? 'bg-nafssiti-dark text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-400 hover:border-nafssiti-primary' }} text-[10px] font-bold uppercase tracking-wider rounded-sm transition">
                À venir
            </a>
            <a href="{{ route('psychologue.rendezVous', ['filter' => 'pending']) }}" 
               class="px-4 py-2 {{ $filter === 'pending' ? 'bg-nafssiti-dark text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-400 hover:border-nafssiti-primary' }} text-[10px] font-bold uppercase tracking-wider rounded-sm transition">
                En attente
            </a>
        </div>
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
            <input type="text" placeholder="Rechercher un patient..."
                class="pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-sm text-[11px] outline-none focus:border-nafssiti-primary w-64 transition">
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-8 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Patient</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Date & Heure</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Type / Notes</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Statut</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($appointments as $appointment)
                <tr class="hover:bg-slate-50/50 transition group">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <img src="{{ $appointment->patient->photo ? asset('storage/' . $appointment->patient->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($appointment->patient->user->name) . '&background=f1f5f9&color=4dbfbf' }}" class="w-8 h-8 rounded-sm">
                            <div>
                                <p class="text-xs font-bold text-slate-800">{{ $appointment->patient->user->name }}</p>
                                <p class="text-[9px] text-slate-400 font-medium italic">Patient NAFSSITI</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-xs font-bold text-slate-700">{{ \Carbon\Carbon::parse($appointment->appointmentDate)->translatedFormat('d F Y') }}</p>
                        <p class="text-[10px] text-nafssiti-primary font-bold">{{ \Carbon\Carbon::parse($appointment->appointmentTime)->format('H:i') }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-[10px] text-slate-600 leading-relaxed max-w-xs truncate">
                            <i class="fas fa-comment-dots mr-1 text-slate-300"></i> Séance thérapeutique
                        </p>
                    </td>
                    <td class="px-8 py-5">
                        @if($appointment->status === 'confirmed')
                            <span class="px-3 py-1 bg-green-50 text-nafssiti-secondary text-[9px] font-bold uppercase rounded-full border border-green-100">Confirmé</span>
                        @elseif($appointment->status === 'pending')
                            <span class="px-3 py-1 bg-amber-50 text-amber-600 text-[9px] font-bold uppercase rounded-full border border-amber-100">En attente</span>
                        @elseif($appointment->status === 'rejected')
                            <span class="px-3 py-1 bg-red-50 text-red-600 text-[9px] font-bold uppercase rounded-full border border-red-100">Refusé</span>
                        @elseif($appointment->status === 'completed')
                            <span class="px-3 py-1 bg-slate-100 text-slate-400 text-[9px] font-bold uppercase rounded-full border border-slate-200">Effectué</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-right">
                        <button class="text-[10px] font-bold text-nafssiti-primary uppercase tracking-tighter hover:underline">Détails</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-10 text-center text-slate-400 italic text-xs">
                        Aucun rendez-vous trouvé pour le moment.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-between items-center px-2">
        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wider italic">Affichage de {{ $appointments->count() }} rendez-vous</p>
        <div class="flex gap-1">
            <button class="w-8 h-8 flex items-center justify-center bg-white border border-slate-200 rounded-sm text-xs text-slate-400 hover:text-nafssiti-primary transition"><i class="fas fa-chevron-left"></i></button>
            <button class="w-8 h-8 flex items-center justify-center bg-white border border-slate-200 rounded-sm text-xs text-slate-400 hover:text-nafssiti-primary transition"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
@endsection
