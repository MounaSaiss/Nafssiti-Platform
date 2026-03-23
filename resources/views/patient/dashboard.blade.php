@extends('layouts.patient')

@section('title', 'Dashboard Patient | NAFSSITI')
@section('header_title', 'Tableau de bord')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Bonjour, {{ Auth::user()->name ?? 'User' }} 👋</h1>
        <p class="text-slate-500 text-sm">Comment vous sentez-vous aujourd'hui ? Voici le résumé de votre suivi.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 border border-slate-200 rounded-sm shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 bg-teal-50 text-nafssiti-primary flex items-center justify-center rounded-sm text-xl">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nombre de rendez-vous</p>
                <p class="text-2xl font-bold text-slate-900">{{ $appointmentsCount }}</p>
            </div>
        </div>

        <div class="bg-white p-6 border border-slate-200 rounded-sm shadow-sm flex items-center gap-5 lg:col-span-2">
            <div class="w-12 h-12 bg-green-50 text-nafssiti-secondary flex items-center justify-center rounded-sm text-xl">
                <i class="fas fa-clock"></i>
            </div>
            <div class="flex-1">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Prochain rendez-vous</p>
                @if($nextAppointment)
                    <div class="flex flex-wrap items-center gap-4 mt-1">
                        <p class="text-lg font-bold text-slate-800">
                            {{ \Carbon\Carbon::parse($nextAppointment->appointmentDate)->translatedFormat('d M Y') }} à {{ \Carbon\Carbon::parse($nextAppointment->appointmentTime)->format('H:i') }}
                        </p>
                        <span class="text-xs px-2 py-0.5 bg-slate-100 text-slate-600 rounded font-medium border border-slate-200">
                            <i class="fas fa-video mr-1"></i> {{ $nextAppointment->psychologist->user->name ?? 'Psychologue' }}
                        </span>
                        <span class="text-[9px] px-2 py-0.5 bg-green-50 text-green-600 rounded-full font-bold border border-green-100 uppercase tracking-tighter">
                            <i class="fas fa-check mr-1"></i> Confirmé
                        </span>
                    </div>
                @else
                    <p class="text-lg font-bold text-slate-400 mt-1">Aucun rendez-vous prévu</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mb-6">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Accès rapide</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('psychologue.allPsychologues') }}"
                class="group bg-white p-6 border border-slate-200 rounded-sm shadow-sm hover:border-nafssiti-primary transition-all flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-slate-50 group-hover:bg-teal-50 text-slate-400 group-hover:text-nafssiti-primary flex items-center justify-center rounded-sm transition">
                        <i class="fas fa-search"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-900 group-hover:text-nafssiti-primary transition">Trouver un psychologue</p>
                        <p class="text-xs text-slate-500">Parcourir les spécialistes disponibles</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-slate-300 group-hover:text-nafssiti-primary transition"></i>
            </a>

            <a href="{{ route('patient.rendezVous') }}"
                class="group bg-white p-6 border border-slate-200 rounded-sm shadow-sm hover:border-nafssiti-secondary transition-all flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-slate-50 group-hover:bg-green-50 text-slate-400 group-hover:text-nafssiti-secondary flex items-center justify-center rounded-sm transition">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-900 group-hover:text-nafssiti-secondary transition">Mes rendez-vous</p>
                        <p class="text-xs text-slate-500">Gérer mes séances et historiques</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-slate-300 group-hover:text-nafssiti-secondary transition"></i>
            </a>
        </div>
    </div>

    <div class="bg-nafssiti-dark text-white p-8 rounded-sm shadow-lg flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="max-w-md">
            <h4 class="text-lg font-bold mb-2 uppercase tracking-tighter">Votre bien-être est notre priorité.</h4>
            <p class="text-slate-400 text-sm">N'oubliez pas que chaque étape, aussi petite soit-elle, est une victoire vers une meilleure santé mentale.</p>
        </div>
        <a href="{{ route('patient.reservation') }}"
            class="bg-nafssiti-secondary hover:bg-green-600 text-white px-8 py-3 rounded-sm font-bold text-xs uppercase tracking-widest shadow-lg transition text-center">
            Réserver une séance
        </a>
    </div>
@endsection
