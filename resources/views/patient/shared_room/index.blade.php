@extends('layouts.patient')

@section('title', 'Mon Suivi Thérapeutique | NAFSSITI')

@section('content')
<div class="max-w-[1200px] mx-auto">
    <!-- Header Section -->
    <div class="mb-8 border-b border-slate-200 pb-6">
        <h1 class="text-[20px] font-bold text-slate-900 tracking-tight">Mon Espace de Suivi</h1>
        <p class="text-[14px] text-slate-500 mt-1">Accompagnement personnalisé avec le <span class="font-semibold text-slate-700">Dr. {{ $psychologist->user->name }}</span></p>
    </div>

    <div class="grid grid-cols-12 gap-8">
        
        <!-- COLONNE PRINCIPALE : PLAN THÉRAPEUTIQUE (8/12) -->
        <div class="col-span-12 lg:col-span-8 space-y-8">
            
            <!-- SECTION RECOMMANDATIONS -->
            <section>
                <h2 class="text-[16px] font-bold text-slate-800 flex items-center gap-2 mb-4">
                    <i class="fas fa-hand-holding-heart text-nafssiti-secondary"></i> Dernières Recommandations
                </h2>
                
                <div class="space-y-4">
                    @forelse($recommendations as $rec)
                        <div class="bg-white border border-slate-200 p-5 rounded-sm shadow-sm relative">
                            <p class="text-[14px] text-slate-700 leading-relaxed">{{ $rec->content }}</p>
                            <div class="mt-3 text-[12px] text-slate-400 font-bold uppercase tracking-wider">
                                Publié le {{ $rec->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                    @empty
                        <div class="bg-slate-50 border border-slate-100 rounded-sm p-8 text-center">
                            <p class="text-[14px] text-slate-500 italic">Votre psychologue n'a pas encore partagé de recommandations spécifiques ici.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- SECTION OBJECTIFS -->
            <section>
                <h2 class="text-[16px] font-bold text-slate-800 flex items-center gap-2 mb-4">
                    <i class="fas fa-bullseye text-nafssiti-primary"></i> Mes Objectifs de Travail
                </h2>
                
                <div class="bg-white border border-slate-200 rounded-sm overflow-hidden shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-3 text-[12px] font-bold text-slate-500 uppercase">Objectif</th>
                                <th class="px-6 py-3 text-[12px] font-bold text-slate-500 uppercase w-32">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($objectives as $obj)
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="text-[14px] {{ $obj->status === 'atteint' ? 'text-slate-400 line-through' : 'text-slate-700 font-medium' }}">
                                            {{ $obj->description }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($obj->status === 'atteint')
                                            <span class="inline-flex items-center gap-1.5 text-[12px] text-teal-600 font-bold">
                                                <i class="fas fa-check-circle"></i> ATTEINT
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-[12px] text-nafssiti-primary font-bold">
                                                <i class="fas fa-spinner fa-spin"></i> EN COURS
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-8 text-center text-[14px] text-slate-400 italic">
                                        Aucun objectif n'a été défini pour le moment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

        </div>

        <!-- COLONNE LATERALE : RENDEZ-VOUS (4/12) -->
        <div class="col-span-12 lg:col-span-4 space-y-8">
            
            <!-- Prochains RDV Layer -->
            <div class="bg-white border border-slate-200 rounded-sm shadow-sm p-5">
                <h2 class="text-[16px] font-bold text-slate-800 mb-6 flex items-center justify-between">
                    Prochaines Séances
                    <i class="fas fa-calendar-check text-slate-300"></i>
                </h2>
                
                <div class="space-y-3 mb-6">
                    @forelse($upcomingAppointments as $apt)
                        <div class="p-4 bg-teal-50 border border-teal-100 rounded-sm">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-[14px] font-bold text-teal-900">{{ \Carbon\Carbon::parse($apt->appointmentDate)->translatedFormat('d F Y') }}</p>
                                <span class="text-[10px] bg-white px-2 py-0.5 rounded-sm border border-teal-200 text-teal-600 font-bold uppercase">Confirmé</span>
                            </div>
                            <p class="text-[12px] text-teal-700">Séance à {{ \Carbon\Carbon::parse($apt->appointmentTime)->format('H:i') }}</p>
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <p class="text-[12px] text-slate-400 italic mb-4">Aucune séance planifiée.</p>
                            <a href="{{ route('patient.reservation') }}" class="inline-block bg-nafssiti-primary text-white text-[12px] font-bold px-4 py-2 rounded-sm shadow-sm hover:bg-teal-500 transition uppercase tracking-wider">
                                Réserver une séance
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Historique Séances -->
            <div class="bg-white border border-slate-200 rounded-sm shadow-sm p-5">
                <h2 class="text-[16px] font-bold text-slate-800 mb-4">Historique Récent</h2>
                <div class="space-y-4">
                    @forelse($pastAppointments->take(5) as $past)
                        <div class="flex items-start gap-3 border-l-2 border-slate-100 pl-4 py-1">
                            <div>
                                <p class="text-[14px] text-slate-700 font-medium">{{ \Carbon\Carbon::parse($past->appointmentDate)->translatedFormat('d F Y') }}</p>
                                <p class="text-[12px] text-slate-400 mt-0.5 uppercase font-bold tracking-tighter">Séance terminée</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-[12px] text-slate-400 italic">Pas encore d'historique de séances.</p>
                    @endforelse
                </div>
            </div>

            <!-- Info Box Conditionnelle -->
            <div class="bg-slate-50 border border-slate-200 p-4 rounded-sm">
                <div class="flex gap-3">
                    <i class="fas fa-info-circle text-slate-400 mt-0.5"></i>
                    <p class="text-[12px] text-slate-500 leading-relaxed">
                        L'Espace de Suivi est confidentiel. Seules les informations utiles à votre évolution clinique sont partagées ici par votre psychologue.
                    </p>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

