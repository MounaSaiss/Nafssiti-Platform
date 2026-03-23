@extends('layouts.psychologue')

@section('title', 'Dashboard Psychologue | NAFSSITI')

@section('content')
    <div class="space-y-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 border-b-4 border-nafssiti-primary rounded-sm shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Rendez-vous</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalAppointments }}</h3>
                <p class="text-[10px] text-nafssiti-secondary font-bold mt-1">Historique complet</p>
            </div>
            <div class="bg-white p-6 border-b-4 border-nafssiti-secondary rounded-sm shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Aujourd'hui</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $appointmentsToday }}</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-1 italic">Séances prévues aujourd'hui</p>
            </div>
            <div class="bg-white p-6 border-b-4 border-nafssiti-dark rounded-sm shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Séances Passées</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $pastAppointments }}</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-1 italic">Terminées ou déjà passées</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <section class="bg-white border border-slate-200 rounded-sm shadow-sm">
                <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-600">Prochaines Séances</h3>
                    <a href="{{ route('psychologue.rendezVous') }}" class="text-[9px] font-bold text-nafssiti-primary uppercase hover:underline">Voir tout</a>
                </div>
                <div class="p-6 space-y-6">
                    @forelse($upcomingUpcoming as $apt)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center gap-4">
                            <img src="{{ $apt->patient->photo ? asset('storage/' . $apt->patient->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($apt->patient->user->name) . '&background=f1f5f9&color=4dbfbf' }}" class="w-9 h-9 rounded-sm">
                            <div>
                                <p class="text-xs font-bold text-slate-800">{{ $apt->patient->user->name }}</p>
                                <p class="text-[10px] text-slate-400 font-medium italic">{{ \Carbon\Carbon::parse($apt->appointmentDate)->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-nafssiti-primary">{{ \Carbon\Carbon::parse($apt->appointmentTime)->format('H:i') }}</p>
                            <p class="text-[9px] text-slate-300 font-bold uppercase">{{ $apt->status === 'confirmed' ? 'Confirmé' : 'En attente' }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-[10px] text-slate-400 italic text-center py-4">Aucune séance prévue prochainement.</p>
                    @endforelse
                </div>
            </section>

            <section class="space-y-6">
                <h3 class="text-xs font-bold uppercase tracking-widest text-slate-600">Actions Rapides</h3>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('psychologue.profil') }}" class="bg-white p-6 border border-slate-200 rounded-sm hover:border-nafssiti-primary transition group text-left">
                        <i class="fas fa-user-edit text-nafssiti-primary mb-3 text-lg group-hover:scale-110 transition"></i>
                        <p class="text-[11px] font-bold text-slate-700 uppercase tracking-tight">Gérer Profil</p>
                        <p class="text-[9px] text-slate-400 mt-1">Éditez vos infos</p>
                    </a>
                    <a href="{{ route('psychologue.disponabilite') }}" class="bg-white p-6 border border-slate-200 rounded-sm hover:border-nafssiti-secondary transition group text-left">
                        <i class="fas fa-calendar-check text-nafssiti-secondary mb-3 text-lg group-hover:scale-110 transition"></i>
                        <p class="text-[11px] font-bold text-slate-700 uppercase tracking-tight">Disponibilités</p>
                        <p class="text-[9px] text-slate-400 mt-1">Ouvrir des créneaux</p>
                    </a>
                </div>
            </section>
        </div>
    </div>
@endsection
