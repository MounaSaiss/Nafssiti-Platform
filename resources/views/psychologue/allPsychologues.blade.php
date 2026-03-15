@extends('layouts.patient')

@section('title', 'Psychologues | NAFSSITI')
@section('header_title', 'Liste des Psychologues')

@section('content')
    <div class="flex flex-col lg:flex-row gap-8">
        <aside class="w-full lg:w-1/4">
            <div class="bg-white p-5 rounded-sm border border-slate-200 shadow-sm sticky top-24">
                <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 mb-5">Filtrer par</h3>
                <div class="space-y-5">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-2 uppercase">Spécialité</label>
                        <select class="w-full bg-slate-50 border border-slate-100 rounded-sm py-2 px-3 text-xs outline-none focus:border-nafssiti-primary transition">
                            <option>Toutes les spécialités</option>
                            <option>Anxiété & Stress</option>
                            <option>Dépression</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-2 uppercase">Ville</label>
                        <select class="w-full bg-slate-50 border border-slate-100 rounded-sm py-2 px-3 text-xs outline-none focus:border-nafssiti-primary transition">
                            <option>Toutes les villes</option>
                            <option>Casablanca</option>
                            <option>Rabat</option>
                        </select>
                    </div>
                    <button class="w-full py-3 bg-nafssiti-dark text-white rounded-sm text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition shadow-md">
                        Rechercher
                    </button>
                </div>
            </div>
        </aside>

        <section class="w-full lg:w-3/4">
            <div class="grid md:grid-cols-2 gap-5">
                <div class="bg-white rounded-sm p-5 border border-slate-200 shadow-sm hover:border-nafssiti-primary/30 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="relative flex-shrink-0">
                            <img src="https://ui-avatars.com/api/?name=Mouna+Tazi&background=4dbfbf&color=fff" class="w-16 h-16 rounded-sm object-cover">
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-nafssiti-secondary border-2 border-white rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-[7px] text-white"></i>
                            </div>
                        </div>

                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-slate-800 tracking-tight">Dr. Mouna Tazi</h3>
                            <p class="text-nafssiti-primary text-[10px] font-medium uppercase mt-0.5">Psychologue clinicienne</p>

                            <div class="mt-2 flex items-center gap-3 text-slate-400">
                                <span class="text-[10px] flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-[9px]"></i> Casablanca
                                </span>
                                <span class="text-[10px] flex items-center gap-1 border-l pl-3 border-slate-100">
                                    <i class="fas fa-star text-amber-400 text-[9px]"></i> 4.9
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-50 flex items-center justify-between">
                        <div>
                            <p class="text-[9px] text-slate-400 uppercase font-bold tracking-tighter">Tarif séance</p>
                            <p class="text-sm font-bold text-slate-700">300 DH</p>
                        </div>
                        <a href="#" class="px-4 py-2 bg-slate-50 text-slate-700 border border-slate-200 rounded-sm text-[9px] font-bold uppercase tracking-widest hover:bg-nafssiti-primary hover:text-white hover:border-nafssiti-primary transition-all">
                            Voir Profil
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-sm p-5 border border-slate-200 shadow-sm hover:border-nafssiti-primary/30 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="relative flex-shrink-0">
                            <img src="https://ui-avatars.com/api/?name=Amine+Bennani&background=96d14b&color=fff" class="w-16 h-16 rounded-sm object-cover">
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-nafssiti-secondary border-2 border-white rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-[7px] text-white"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-slate-800 tracking-tight">Dr. Amine Bennani</h3>
                            <p class="text-nafssiti-primary text-[10px] font-medium uppercase mt-0.5">Thérapeute TCC</p>
                            <div class="mt-2 flex items-center gap-3 text-slate-400">
                                <span class="text-[10px] flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-[9px]"></i> Rabat
                                </span>
                                <span class="text-[10px] flex items-center gap-1 border-l pl-3 border-slate-100">
                                    <i class="fas fa-star text-amber-400 text-[9px]"></i> 4.8
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-50 flex items-center justify-between">
                        <div>
                            <p class="text-[9px] text-slate-400 uppercase font-bold tracking-tighter">Tarif séance</p>
                            <p class="text-sm font-bold text-slate-700">250 DH</p>
                        </div>
                        <a href="#" class="px-4 py-2 bg-slate-50 text-slate-700 border border-slate-200 rounded-sm text-[9px] font-bold uppercase tracking-widest hover:bg-nafssiti-primary hover:text-white hover:border-nafssiti-primary transition-all">
                            Voir Profil
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
