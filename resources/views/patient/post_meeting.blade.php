@extends('layouts.patient')

@section('title', 'Bilan de Consultation | NAFSSITI')
@section('header_title', 'Bilan de Consultation')

@section('content')
<div class="max-w-2xl mx-auto mt-6">

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-sm flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-sm flex items-center gap-3">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    @if(!$appointment)
        {{-- Aucune séance --}}
        <div class="bg-white rounded-sm shadow-sm border border-slate-200 p-8 text-center text-slate-500">
            <i class="fas fa-info-circle text-2xl mb-3 text-slate-300"></i>
            <h3 class="text-base font-bold text-slate-700">Aucune séance récente</h3>
            <p class="mt-1 text-sm">Vous n'avez pas de séance récente nécessitant un bilan ou en attente d'évaluation.</p>
        </div>
    @else
        {{-- CARTE PRINCIPALE --}}
        <div class="bg-white rounded-sm shadow-sm border border-slate-200 overflow-hidden">

            @if($appointment->consultation_status === 'pending')
                {{-- ETAT: PENDING --}}
                <div class="bg-blue-50 border-b border-blue-100 p-6 text-center">
                    <div class="w-12 h-12 bg-white rounded-sm flex items-center justify-center mx-auto mb-3 shadow-sm text-blue-500 text-xl">
                        <i class="fas fa-hourglass-half animate-pulse"></i>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800 mb-1">Consultation en attente</h2>
                    <p class="text-sm text-slate-600">Vous n'avez pas encore terminé votre première consultation. Revenez ici une fois la séance achevée pour donner votre avis.</p>
                </div>
            @else
                {{-- ETAT: COMPLETED (A EVALUER) --}}
                <div class="bg-teal-50 border-b border-teal-100 p-6 text-center">
                    <div class="w-12 h-12 bg-white rounded-sm flex items-center justify-center mx-auto mb-3 shadow-sm text-nafssiti-primary text-xl">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800 mb-2">Séance Terminée</h2>
                    <p class="text-sm text-slate-600">
                        Votre consultation vidéo avec le <strong>Dr. {{ $appointment->psychologist->user->name ?? 'Praticien' }}</strong> (le {{ \Carbon\Carbon::parse($appointment->appointmentDate)->translatedFormat('d M Y') }} à {{ \Carbon\Carbon::parse($appointment->appointmentTime)->format('H:i') }}) est à présent terminée.
                    </p>
                </div>

                {{-- Corps de la carte --}}
                <div class="p-6">
                    <div class="text-center mb-6">
                        <h3 class="text-base font-bold text-slate-800">Êtes-vous satisfait(e) pour commencer le suivi avec ce psychologue ou non ?</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($followRequest)
                            {{-- Demande déjà envoyée --}}
                            <div class="md:col-span-2 bg-green-50 border border-green-200 rounded-sm p-4 flex items-center gap-4">
                                <div class="w-10 h-10 bg-green-100 text-green-600 flex items-center justify-center rounded-sm shrink-0">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-green-800">Demande envoyée</h4>
                                    <p class="text-xs text-green-700 mt-0.5">
                                        @if($followRequest->status === 'pending')
                                            Votre demande de suivi est en attente d'acceptation par le psychologue.
                                        @elseif($followRequest->status === 'accepted')
                                            Votre demande de suivi a été <strong>acceptée</strong>. Vous pouvez désormais prendre rendez-vous régulièrement.
                                        @elseif($followRequest->status === 'rejected')
                                            Votre demande de suivi a été <strong>refusée</strong> par le psychologue.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @else
                            {{-- Option 1: Commencer le suivi --}}
                            <form action="{{ route('patient.follow_request.store', $appointment) }}" method="POST">
                                @csrf
                                <input type="hidden" name="decision" value="follow_up">
                                <button type="submit" class="w-full h-full group bg-white border border-slate-200 hover:border-nafssiti-primary rounded-sm p-4 text-left transition flex items-center gap-4 hover:shadow-sm">
                                    <div class="w-10 h-10 bg-slate-50 text-slate-400 group-hover:bg-teal-50 group-hover:text-nafssiti-primary flex items-center justify-center rounded-sm transition shrink-0">
                                        <i class="fas fa-heartbeat"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900 group-hover:text-nafssiti-primary transition">Commencer le suivi</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">Je souhaite continuer les séances.</p>
                                    </div>
                                </button>
                            </form>

                            {{-- Option 2: Non satisfait --}}
                            <form action="#" method="POST">
                                @csrf
                                <input type="hidden" name="decision" value="not_satisfied">
                                <button type="submit" class="w-full h-full group bg-white border border-slate-200 hover:border-red-400 rounded-sm p-4 text-left transition flex items-center gap-4 hover:shadow-sm">
                                    <div class="w-10 h-10 bg-slate-50 text-slate-400 group-hover:bg-red-50 group-hover:text-red-500 flex items-center justify-center rounded-sm transition shrink-0">
                                        <i class="fas fa-frown"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900 group-hover:text-red-500 transition">Non satisfait(e)</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">L'approche ne m'a pas convenu.</p>
                                    </div>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                {{-- Informations supplémentaires --}}
                <div class="bg-slate-50 p-4 border-t border-slate-100 flex items-start gap-3">
                    <i class="fas fa-info-circle text-nafssiti-secondary mt-0.5 text-sm"></i>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Conformément à nos conditions d'utilisation, vous avez la possibilité d'exprimer votre niveau de satisfaction à la fin de chaque première consultation. Votre retour est strictement confidentiel.
                    </p>
                </div>
            @endif

        </div>
    @endif

</div>
@endsection
