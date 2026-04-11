@extends('layouts.patient')

@section('title', 'Mes Rendez-vous | NAFSSITI')
@section('header_title', 'Gestion de mes séances')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Mes Rendez-vous</h1>
            <p class="text-slate-400 text-xs mt-1 font-medium">Suivez et gérez votre parcours de santé mentale.</p>
        </div>

        <div class="flex p-1 bg-slate-100 rounded-lg border border-slate-200">
            <a href="{{ route('patient.rendezVous', ['status' => 'à-venir']) }}" 
               class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest rounded-md transition-all {{ $statusFilter === 'à-venir' ? 'bg-white text-nafssiti-primary shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
               À venir
            </a>
            <a href="{{ route('patient.rendezVous', ['status' => 'en-attente']) }}" 
               class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest rounded-md transition-all {{ $statusFilter === 'en-attente' ? 'bg-white text-nafssiti-primary shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
               En attente
            </a>
            <a href="{{ route('patient.rendezVous', ['status' => 'refuse']) }}" 
               class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest rounded-md transition-all {{ $statusFilter === 'refuse' ? 'bg-white text-nafssiti-primary shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
               Refusé
            </a>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Date & Heure</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Psychologue</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Statut
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($appointments as $appointment)
                    <tr
                        class="{{ in_array($appointment->status, ['completed', 'rejected']) ? 'bg-slate-50/30' : 'hover:bg-slate-50/50 transition' }}">
                        <td class="px-6 py-5">
                            <p class="text-xs font-bold text-slate-700">
                                {{ \Carbon\Carbon::parse($appointment->appointmentDate)->translatedFormat('d F Y') }}</p>
                            <p class="text-[10px] text-slate-400 font-medium">
                                {{ \Carbon\Carbon::parse($appointment->appointmentTime)->format('H:i') }} (45 min)</p>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <img src="{{ $appointment->psychologist->photo ? asset('storage/' . $appointment->psychologist->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($appointment->psychologist->user->name) . '&background=4dbfbf&color=fff' }}"
                                    class="w-7 h-7 rounded-sm">
                                <div>
                                    <p class="text-xs font-bold text-slate-700">{{ $appointment->psychologist->user->name }}
                                    </p>
                                    <p class="text-[9px] text-nafssiti-primary font-bold uppercase tracking-tighter">
                                        {{ $appointment->psychologist->specialization }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-right">
                            @if ($appointment->status === 'confirmed')
                                <div class="flex flex-col items-end gap-2">
                                    <div class="flex items-center gap-2">
                                        @if($appointment->consultation_status === 'completed')
                                            <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[9px] font-bold uppercase rounded-full border border-slate-200">Séance Terminée</span>
                                        @endif
                                        <span class="px-3 py-1 bg-green-50 text-nafssiti-secondary text-[9px] font-bold uppercase rounded-full border border-green-100">Confirmé</span>
                                    </div>
                                    @if($appointment->consultation_status !== 'completed')
                                        <a href="{{ route('meeting.join', $appointment) }}" class="flex items-center gap-2 px-3 py-1.5 bg-nafssiti-primary text-white text-[9px] font-bold uppercase rounded-sm hover:bg-nafssiti-secondary transition shadow-sm">
                                            <i class="fas fa-video animate-pulse"></i> Rejoindre séance
                                        </a>
                                    @endif
                                </div>
                            @elseif($appointment->status === 'pending')
                                <span
                                    class="px-3 py-1 bg-amber-50 text-amber-500 text-[9px] font-bold uppercase rounded-full border border-amber-100">En
                                    attente</span>
                            @elseif($appointment->status === 'rejected')
                                <div class="flex flex-col items-end gap-2">
                                    <span
                                        class="px-3 py-1 bg-red-50 text-red-500 text-[9px] font-bold uppercase rounded-full border border-red-100">Refusé</span>
                                    <button type="button" onclick="toggleRejectionReason({{ $appointment->id }})" class="text-[9px] font-bold text-slate-400 hover:text-nafssiti-primary uppercase tracking-widest flex items-center gap-1 transition">
                                        Voir plus <i class="fas fa-chevron-down transition-transform" id="icon-reason-{{ $appointment->id }}"></i>
                                    </button>
                                </div>
                            @else
                                <span
                                    class="px-3 py-1 bg-slate-100 text-slate-400 text-[9px] font-bold uppercase rounded-full border border-slate-200">{{ $appointment->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @if($appointment->status === 'rejected')
                    <tr id="reason-{{ $appointment->id }}" class="hidden bg-red-50/20">
                        <td colspan="3" class="px-6 py-4 border-t border-red-100/30">
                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0 text-red-500">
                                    <i class="fas fa-comment-alt text-[10px]"></i>
                                </div>
                                <div>
                                    <p class="text-[9px] font-bold uppercase tracking-widest text-red-500 mb-1">Message du Psychologue</p>
                                    <p class="text-[11px] text-slate-600 whitespace-pre-line leading-relaxed">{{ $appointment->rejection_reason ?? 'Aucun motif de refus spécifié par le psychologue.' }}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif

                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-20 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5 text-slate-200">
                                @if($statusFilter === 'à-venir')
                                    <i class="fas fa-calendar-check text-3xl"></i>
                                @elseif($statusFilter === 'en-attente')
                                    <i class="fas fa-hourglass-half text-3xl"></i>
                                @else
                                    <i class="fas fa-ban text-3xl"></i>
                                @endif
                            </div>
                            <h3 class="text-base font-bold text-slate-800">Aucun rendez-vous trouvé</h3>
                            <p class="text-slate-400 text-xs mt-2 max-w-xs mx-auto">
                                @if($statusFilter === 'à-venir')
                                    Vous n'avez pas encore de sessions confirmées pour les jours à venir.
                                @elseif($statusFilter === 'en-attente')
                                    Toutes vos demandes de réservation ont été traitées ou vous n'en avez pas encore fait.
                                @else
                                    Vous n'avez aucun rendez-vous refusé par nos psychologues.
                                @endif
                            </p>
                            @if($statusFilter === 'à-venir')
                                <a href="{{ route('patient.reservation') }}" class="mt-8 inline-flex items-center gap-2 bg-nafssiti-secondary hover:bg-green-600 text-white px-8 py-3 rounded-sm font-bold text-[11px] uppercase tracking-widest transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i class="fas fa-plus"></i> Réserver une nouvelle séance
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection

@section('scripts')
<script>
    function toggleRejectionReason(id) {
        const reasonRow = document.getElementById(`reason-${id}`);
        const icon = document.getElementById(`icon-reason-${id}`);
        
        if (reasonRow.classList.contains('hidden')) {
            reasonRow.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            reasonRow.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
</script>
@endsection
