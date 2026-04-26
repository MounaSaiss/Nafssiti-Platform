@extends('layouts.patient')

@section('title', 'Bilan de Consultation | NAFSSITI')
@section('header_title', 'Bilan de Consultation')

@section('content')
    <div class="max-w-2xl mx-auto mt-6">

        @if (!$appointment)
            {{-- Aucune séance --}}
            <div class="bg-white rounded-sm shadow-sm border border-slate-200 p-8 text-center text-slate-500">
                <i class="fas fa-info-circle text-2xl mb-3 text-slate-300"></i>
                <h3 class="text-base font-bold text-slate-700">Aucune séance récente</h3>
                <p class="mt-1 text-sm">Vous n'avez pas de séance récente nécessitant un bilan ou en attente d'évaluation.
                </p>
            </div>
        @else
            {{-- CARTE PRINCIPALE --}}
            <div class="bg-white rounded-sm shadow-sm border border-slate-200 overflow-hidden">

                @if ($appointment->consultation_status === 'pending')
                    {{-- ETAT: PENDING --}}
                    <div class="bg-blue-50 border-b border-blue-100 p-6 text-center">
                        <div
                            class="w-12 h-12 bg-white rounded-sm flex items-center justify-center mx-auto mb-3 shadow-sm text-blue-500 text-xl">
                            <i class="fas fa-hourglass-half animate-pulse"></i>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800 mb-1">Consultation en attente</h2>
                        <p class="text-sm text-slate-600">Vous n'avez pas encore terminé votre première consultation.
                            Revenez ici une fois la séance achevée pour donner votre avis.</p>
                        <div class="mt-6">
                            @if($followRequest && $followRequest->status === 'accepted')
                                <a href="{{ route('patient.shared_room.index', $appointment->psychologist_id) }}" 
                                   class="inline-flex items-center gap-2 bg-nafssiti-primary text-white border border-nafssiti-primary px-6 py-2.5 rounded-sm font-bold shadow-sm transition-all hover:bg-teal-500 text-xs uppercase tracking-widest">
                                    <i class="fas fa-folder-open"></i> Accéder à mon dossier partagé
                                </a>
                            @else
                                <a href="{{ route('patient.dashboard') }}" 
                                   class="inline-flex items-center gap-2 bg-white border border-blue-200 text-blue-600 px-6 py-2.5 rounded-sm font-bold shadow-sm transition-all hover:bg-blue-50 text-xs uppercase tracking-widest">
                                    <i class="fas fa-arrow-left"></i> Retour au Dashboard
                                </a>
                            @endif
                        </div>
                    </div>
                @else
                    {{-- ETAT: COMPLETED (A EVALUER) --}}
                    <div class="bg-teal-50 border-b border-teal-100 p-6 text-center">
                        <div
                            class="w-12 h-12 bg-white rounded-sm flex items-center justify-center mx-auto mb-3 shadow-sm text-nafssiti-primary text-xl">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800 mb-2">Séance Terminée</h2>
                        <p class="text-sm text-slate-600">
                            Votre consultation vidéo avec le <strong>Dr.
                                {{ $appointment->psychologist->user->name ?? 'Praticien' }}</strong> (le
                            {{ \Carbon\Carbon::parse($appointment->appointmentDate)->translatedFormat('d M Y') }} à
                            {{ \Carbon\Carbon::parse($appointment->appointmentTime)->format('H:i') }}) est à présent
                            terminée.
                        </p>
                        @if($followRequest && $followRequest->status === 'accepted')
                            <div class="mt-4 pt-4 border-t border-teal-100/50">
                                <a href="{{ route('patient.shared_room.index', $appointment->psychologist_id) }}" 
                                   class="inline-flex items-center gap-2 bg-nafssiti-primary hover:bg-teal-500 text-white px-6 py-2.5 rounded-sm font-bold shadow-sm transition-all transform hover:-translate-y-0.5 text-xs">
                                    <i class="fas fa-folder-open"></i> Accéder à mon dossier partagé
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Section to hide completely on 'Non Satisfait' --}}
                    <div id="decision-section">
                        {{-- Corps de la carte --}}
                        <div class="p-6">
                        <div class="text-center mb-6">
                            <h3 class="text-base font-bold text-slate-800">Êtes-vous satisfait(e) pour commencer le suivi
                                avec ce psychologue ou non ?</h3>
                        </div>

                        <div id="action-buttons-grid" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if ($followRequest)
                                {{-- Demande déjà envoyée --}}
                                @php
                                    $statusClasses = [
                                        'wrapper' => 'bg-green-50 border-green-200',
                                        'icon_bg' => 'bg-green-100 text-green-600',
                                        'title' => 'text-green-800',
                                        'text' => 'text-green-700',
                                        'title_text' => 'Demande envoyée',
                                    ];

                                    if ($followRequest->status === 'accepted') {
                                        $statusClasses = [
                                            'wrapper' => 'bg-orange-50 border-orange-200',
                                            'icon_bg' => 'bg-orange-100 text-orange-600',
                                            'title' => 'text-orange-800',
                                            'text' => 'text-orange-700',
                                            'title_text' => 'Demande acceptée',
                                        ];
                                    } elseif ($followRequest->status === 'rejected') {
                                        $statusClasses = [
                                            'wrapper' => 'bg-red-50 border-red-200',
                                            'icon_bg' => 'bg-red-100 text-red-600',
                                            'title' => 'text-red-800',
                                            'text' => 'text-red-700',
                                            'title_text' => 'Demande refusée',
                                        ];
                                    }
                                @endphp
                                <div
                                    class="md:col-span-2 border rounded-sm p-4 flex items-center gap-4 {{ $statusClasses['wrapper'] }}">
                                    <div
                                        class="w-10 h-10 flex items-center justify-center rounded-sm shrink-0 {{ $statusClasses['icon_bg'] }}">
                                        @if ($followRequest->status === 'accepted')
                                            <i class="fas fa-check-circle"></i>
                                        @elseif($followRequest->status === 'rejected')
                                            <i class="fas fa-times-circle"></i>
                                        @else
                                            <i class="fas fa-hourglass-half"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold {{ $statusClasses['title'] }}">
                                            {{ $statusClasses['title_text'] }}</h4>
                                        <div class="text-xs mt-0.5 {{ $statusClasses['text'] }}">
                                            @if ($followRequest->status === 'pending')
                                                <p>Votre demande de suivi est en attente d'acceptation par le psychologue.
                                                </p>
                                            @elseif($followRequest->status === 'accepted')
                                                <p>Votre demande de suivi a été <strong>acceptée</strong>. Vous pouvez
                                                    désormais bénéficier de votre espace de suivi personnalisé.</p>
                                                <div class="mt-4">
                                                    <a href="{{ route('patient.shared_room.index', $appointment->psychologist_id) }}" 
                                                       class="inline-flex items-center gap-2 bg-nafssiti-primary hover:bg-teal-500 text-white px-5 py-2.5 rounded-sm font-bold shadow-sm transition-all transform hover:-translate-y-0.5">
                                                        <i class="fas fa-desktop"></i> Accéder à mon Espace de Suivi
                                                    </a>
                                                </div>
                                            @elseif($followRequest->status === 'rejected')
                                                <p>Le praticien ne peut malheureusement pas démarrer de suivi avec de
                                                    nouveaux patients actuellement, mais votre parcours de bien-être
                                                    continue !</p>
                                                <div class="mt-3">
                                                    <a href="{{ route('psychologue.allPsychologues') }}"
                                                        class="inline-flex items-center gap-1.5 bg-white text-red-600 border border-red-200 hover:bg-red-50 hover:border-red-300 px-4 py-2 rounded-sm font-bold transition shadow-sm">
                                                        <i class="fas fa-search"></i> Trouver un autre psychologue
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- Option 1: Commencer le suivi --}}
                                <form action="{{ route('patient.follow_request.store', $appointment) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="decision" value="follow_up">
                                    <button type="submit"
                                        class="w-full h-full group bg-white border border-slate-200 hover:border-nafssiti-primary rounded-sm p-4 text-left transition flex items-center gap-4 hover:shadow-sm">
                                        <div
                                            class="w-10 h-10 bg-slate-50 text-slate-400 group-hover:bg-teal-50 group-hover:text-nafssiti-primary flex items-center justify-center rounded-sm transition shrink-0">
                                            <i class="fas fa-heartbeat"></i>
                                        </div>
                                        <div>
                                            <h4
                                                class="text-sm font-bold text-slate-900 group-hover:text-nafssiti-primary transition">
                                                Commencer le suivi</h4>
                                            <p class="text-xs text-slate-500 mt-0.5">Je souhaite continuer les séances.</p>
                                        </div>
                                    </button>
                                </form>

                                {{-- Option 2: Non satisfait --}}
                                <button type="button" onclick="handleNotSatisfied()"
                                    class="w-full h-full group bg-white border border-slate-200 hover:border-red-400 rounded-sm p-4 text-left transition flex items-center gap-4 hover:shadow-sm">
                                    <div
                                        class="w-10 h-10 bg-slate-50 text-slate-400 group-hover:bg-red-50 group-hover:text-red-500 flex items-center justify-center rounded-sm transition shrink-0">
                                        <i class="fas fa-frown"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900 group-hover:text-red-500 transition">
                                            Non satisfait(e)</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">L'approche ne m'a pas convenu.</p>
                                    </div>
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- Hidden Message Box (Shown on "Non satisfait" click) --}}
                    <div id="msg-not-satisfied" class="hidden p-6 border-t border-slate-100">
                        <div class="bg-red-50 border border-red-200 rounded-sm p-4 flex items-start flex-col sm:flex-row gap-4">
                            <div class="w-10 h-10 bg-red-100 text-red-600 flex items-center justify-center rounded-sm shrink-0">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-red-800">Nous comprenons votre décision.</h4>
                                <p class="text-xs text-red-700 mt-1 leading-relaxed">
                                    Il est tout à fait normal de ne pas trouver le praticien idéal du premier coup. Votre
                                    choix est enregistré et aucun suivi ne sera initié avec
                                    {{ $appointment->psychologist->user->name ?? 'ce psychologue' }}. Votre parcours de
                                    bien-être continue !
                                </p>
                                <div class="mt-4">
                                    <a href="{{ route('psychologue.allPsychologues') }}"
                                        class="inline-flex items-center gap-1.5 bg-white text-red-600 border border-red-200 hover:bg-red-50 hover:border-red-300 px-4 py-2 rounded-sm font-bold transition shadow-sm text-xs">
                                        <i class="fas fa-search"></i> Trouver un autre psychologue
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        @endif

    </div>
@endsection

@section('scripts')
    <script>
        function handleNotSatisfied() {
            // Hide the entire decision section (question, buttons, and footer)
            document.getElementById('decision-section').classList.add('hidden');
            // Show the feedback message
            document.getElementById('msg-not-satisfied').classList.remove('hidden');
        }
    </script>
@endsection
