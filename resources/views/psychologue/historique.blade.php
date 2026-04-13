@extends('layouts.psychologue')

@section('title', 'Historique des Rendez-vous | Psychologue')
@section('header_title', 'Mon Historique')

@section('content')
    <div class="max-w-6xl">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
            <div>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Mon Historique</h1>
                <p class="text-slate-400 text-xs mt-1 font-medium">Consultez l'historique de vos séances passées.</p>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="flex p-1 bg-slate-100 rounded-lg border border-slate-200 mb-8 inline-flex">
            <a href="{{ route('psychologue.historique', ['status' => 'all']) }}"
                class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest rounded-md transition-all {{ !request('status') || request('status') == 'all' ? 'bg-white text-nafssiti-primary shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                Tout
            </a>
            <a href="{{ route('psychologue.historique', ['status' => 'confirmed']) }}"
                class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest rounded-md transition-all {{ request('status') == 'confirmed' ? 'bg-white text-emerald-500 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                Confirmés
            </a>
            <a href="{{ route('psychologue.historique', ['status' => 'rejected']) }}"
                class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest rounded-md transition-all {{ request('status') == 'rejected' ? 'bg-white text-red-500 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                Refusés
            </a>
            <a href="{{ route('psychologue.historique', ['status' => 'cancelled']) }}"
                class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest rounded-md transition-all {{ request('status') == 'cancelled' ? 'bg-white text-slate-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                Annulés
            </a>
        </div>

        <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Patient</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Date & Heure
                        </th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $appointment->patient->user->avatar ? asset('storage/' . $appointment->patient->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($appointment->patient->user->name) . '&background=4dbfbf&color=fff' }}"
                                        class="w-7 h-7 rounded-sm object-cover">
                                    <div>
                                        <p class="text-xs font-bold text-slate-700">{{ $appointment->patient->user->name }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-xs font-bold text-slate-700">
                                    {{ \Carbon\Carbon::parse($appointment->appointmentDate)->translatedFormat('d F Y') }}</p>
                                <p class="text-[10px] text-slate-400 font-medium">
                                    {{ \Carbon\Carbon::parse($appointment->appointmentTime)->format('H:i') }} (45 min)</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if ($appointment->status === 'confirmed')
                                    <div class="flex flex-col items-end gap-2">
                                        <div class="flex items-center gap-2">
                                            <span class="px-3 py-1 bg-green-50 text-nafssiti-secondary text-[9px] font-bold uppercase rounded-full border border-green-100">Accepté</span>
                                            @if($appointment->consultation_status === 'completed')
                                                <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[9px] font-bold uppercase rounded-full border border-slate-200">
                                                    <i class="fas fa-check-double mr-1 text-slate-400"></i> Séance Terminée
                                                </span>
                                            @endif
                                        </div>
                                        
                                        @if($appointment->consultation_status !== 'completed')
                                            <div class="flex items-center gap-2">
                                                <form action="{{ route('psychologue.appointments.complete', $appointment) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment marquer cette séance comme terminée ? Cela coupera l\'accès vidéo.')">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 text-[9px] font-bold uppercase rounded-sm border border-red-100 hover:bg-red-500 hover:text-white transition shadow-sm">
                                                        <i class="fas fa-times-circle"></i> Terminer séance
                                                    </button>
                                                </form>
                                                <a href="{{ route('meeting.join', $appointment) }}" class="flex items-center gap-2 px-3 py-1.5 bg-nafssiti-primary text-white text-[9px] font-bold uppercase rounded-sm hover:bg-nafssiti-secondary transition shadow-sm">
                                                    <i class="fas fa-play text-[8px]"></i> Démarrer séance
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @elseif($appointment->status === 'rejected')
                                    <span
                                        class="px-3 py-1 bg-red-50 text-red-500 text-[9px] font-bold uppercase rounded-full border border-red-100">Refusé</span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-slate-100 text-slate-400 text-[9px] font-bold uppercase rounded-full border border-slate-200">Annulé</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3"
                                class="px-6 py-12 text-center text-[10px] text-slate-400 uppercase tracking-widest font-medium italic">
                                Aucun rendez-vous trouvé dans l'historique.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
