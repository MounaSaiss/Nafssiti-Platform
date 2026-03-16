@extends('layouts.patient')

@section('title', 'Mes Rendez-vous | NAFSSITI')
@section('header_title', 'Gestion de mes séances')

@section('content')
    <div class="mb-8">
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">Historique & Planning</h1>
        <p class="text-slate-400 text-xs mt-1 font-medium">Consultez, gérez ou annulez vos rendez-vous en cours.</p>
    </div>

    <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Date & Heure</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Psychologue</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Statut</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($appointments as $appointment)
                <tr class="{{ in_array($appointment->status, ['completed', 'refused']) ? 'opacity-60 bg-slate-50/30' : 'hover:bg-slate-50/50 transition' }}">
                    <td class="px-6 py-5">
                        <p class="text-xs font-bold text-slate-700">{{ \Carbon\Carbon::parse($appointment->appointmentDate)->translatedFormat('d F Y') }}</p>
                        <p class="text-[10px] text-slate-400 font-medium">{{ \Carbon\Carbon::parse($appointment->appointmentTime)->format('H:i') }} (45 min)</p>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <img src="{{ $appointment->psychologist->photo ? asset('storage/' . $appointment->psychologist->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($appointment->psychologist->user->name) . '&background=4dbfbf&color=fff' }}" class="w-7 h-7 rounded-sm">
                            <div>
                                <p class="text-xs font-bold text-slate-700">{{ $appointment->psychologist->user->name }}</p>
                                <p class="text-[9px] text-nafssiti-primary font-bold uppercase tracking-tighter">{{ $appointment->psychologist->specialization }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        @if($appointment->status === 'accepted')
                            <span class="px-3 py-1 bg-green-50 text-nafssiti-secondary text-[9px] font-bold uppercase rounded-full border border-green-100">Confirmé</span>
                        @elseif($appointment->status === 'pending')
                            <span class="px-3 py-1 bg-amber-50 text-amber-500 text-[9px] font-bold uppercase rounded-full border border-amber-100">En attente</span>
                        @elseif($appointment->status === 'refused')
                            <span class="px-3 py-1 bg-red-50 text-red-500 text-[9px] font-bold uppercase rounded-full border border-red-100">Annulé</span>
                        @elseif($appointment->status === 'completed')
                            <span class="px-3 py-1 bg-slate-100 text-slate-400 text-[9px] font-bold uppercase rounded-full border border-slate-200">Effectué</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-right">
                        @if($appointment->status === 'pending' || $appointment->status === 'accepted')
                        <button class="text-[10px] font-bold text-red-400 uppercase tracking-widest hover:text-red-600 transition flex items-center gap-2 ml-auto" title="Annuler le rendez-vous">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                        @else
                        <span class="italic text-[10px] text-slate-400">Aucune action</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center">
                        <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300">
                            <i class="fas fa-calendar-times text-xl"></i>
                        </div>
                        <p class="text-slate-500 font-medium text-xs">Vous n'avez pas encore de rendez-vous.</p>
                        <a href="{{ route('patient.reservation') }}" class="text-nafssiti-primary text-[10px] font-bold uppercase mt-2 inline-block hover:underline">Réserver ma première séance</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex items-center gap-3 bg-blue-50/50 p-4 border border-blue-100 rounded-sm">
        <i class="fas fa-info-circle text-blue-400 text-xs"></i>
        <p class="text-[10px] text-blue-600 font-medium">Les annulations doivent être effectuées au moins 24 heures à l'avance pour être éligibles à un remboursement ou report.</p>
    </div>
@endsection
