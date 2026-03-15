@extends('layouts.psychologue')

@section('title', 'Dashboard Psychologue | NAFSSITI')

@section('content')
    <div class="space-y-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 border-b-4 border-nafssiti-primary rounded-sm shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Rendez-vous</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">128</h3>
                <p class="text-[10px] text-nafssiti-secondary font-bold mt-1">+12% ce mois</p>
            </div>
            <div class="bg-white p-6 border-b-4 border-nafssiti-secondary rounded-sm shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Aujourd'hui</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">4</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-1 text-italic italic">Prochaine à 14:00</p>
            </div>
            <div class="bg-white p-6 border-b-4 border-nafssiti-dark rounded-sm shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Séances Passées</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">114</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-1 italic">Taux de présence: 98%</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <section class="bg-white border border-slate-200 rounded-sm shadow-sm">
                <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-600">Prochaines Séances</h3>
                    <a href="{{ route('psychologue.rendezVous') }}" class="text-[9px] font-bold text-nafssiti-primary uppercase hover:underline">Voir tout</a>
                </div>
                <div class="p-6 space-y-6">
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name=Karim+I&background=f1f5f9&color=4dbfbf" class="w-9 h-9 rounded-sm">
                            <div>
                                <p class="text-xs font-bold text-slate-800">Karim Idrissi</p>
                                <p class="text-[10px] text-slate-400 font-medium italic">Anxiété sociale</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-nafssiti-primary">14:00</p>
                            <p class="text-[9px] text-slate-300 font-bold uppercase">Aujourd'hui</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name=Sara+L&background=f1f5f9&color=4dbfbf" class="w-9 h-9 rounded-sm">
                            <div>
                                <p class="text-xs font-bold text-slate-800">Sara Lemrani</p>
                                <p class="text-[10px] text-slate-400 font-medium italic">Suivi thérapie</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-800">16:30</p>
                            <p class="text-[9px] text-slate-300 font-bold uppercase">Aujourd'hui</p>
                        </div>
                    </div>
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
                <div class="bg-nafssiti-dark p-8 rounded-sm text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h4 class="text-sm font-bold">Besoin d'aide ?</h4>
                        <p class="text-[10px] text-slate-400 mt-2 max-w-[200px]">Consultez notre guide de gestion de cabinet ou contactez le support pro.</p>
                        <button class="mt-4 bg-nafssiti-primary px-4 py-2 rounded-sm text-[9px] font-bold uppercase tracking-widest">Support Nafssiti</button>
                    </div>
                    <i class="fas fa-stethoscope absolute -right-4 -bottom-4 text-7xl text-white/5 rotate-12"></i>
                </div>
            </section>
        </div>
    </div>
@endsection
