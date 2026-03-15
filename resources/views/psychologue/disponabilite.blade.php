@extends('layouts.psychologue')

@section('title', 'Gestion des Disponibilités | NAFSSITI')
@section('header_title', "Gestion de l'Emploi du temps")

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="bg-white p-6 border border-slate-200 rounded-sm shadow-sm sticky top-28">
                <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600 mb-6 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-nafssiti-primary"></i> Nouveau Créneau
                </h3>

                <form class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Jour de la semaine</label>
                        <select class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                            <option>Lundi</option>
                            <option>Mardi</option>
                            <option>Mercredi</option>
                            <option>Jeudi</option>
                            <option>Vendredi</option>
                            <option>Samedi</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">De (Heure)</label>
                            <input type="time" class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">À (Heure)</label>
                            <input type="time" class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-nafssiti-primary text-white rounded-sm text-[10px] font-bold uppercase tracking-widest hover:bg-nafssiti-dark transition shadow-md">
                        Ajouter à mon planning
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Mes Horaires Hebdomadaires</h3>
                <span class="text-[9px] text-slate-400 font-medium italic">Modifiez ou supprimez vos heures de consultation</span>
            </div>

            <div class="bg-white border border-slate-200 rounded-sm overflow-hidden shadow-sm">
                <div class="bg-slate-50 px-6 py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="text-xs font-bold text-slate-700 uppercase tracking-tight">Lundi</span>
                    <span class="text-[9px] bg-nafssiti-primary/10 text-nafssiti-primary px-2 py-1 rounded-full font-bold">2 Créneaux</span>
                </div>
                <div class="p-6 flex flex-wrap gap-4">
                    <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 px-4 py-2 rounded-sm group hover:border-nafssiti-primary transition">
                        <span class="text-xs font-semibold text-slate-600">10:00 - 12:00</span>
                        <button class="text-slate-300 hover:text-nafssiti-accent transition"><i class="fas fa-times-circle text-sm"></i></button>
                    </div>
                    <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 px-4 py-2 rounded-sm group hover:border-nafssiti-primary transition">
                        <span class="text-xs font-semibold text-slate-600">14:00 - 17:00</span>
                        <button class="text-slate-300 hover:text-nafssiti-accent transition"><i class="fas fa-times-circle text-sm"></i></button>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-sm overflow-hidden shadow-sm">
                <div class="bg-slate-50 px-6 py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="text-xs font-bold text-slate-700 uppercase tracking-tight">Mardi</span>
                    <span class="text-[9px] bg-nafssiti-primary/10 text-nafssiti-primary px-2 py-1 rounded-full font-bold">1 Créneau</span>
                </div>
                <div class="p-6 flex flex-wrap gap-4">
                    <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 px-4 py-2 rounded-sm group hover:border-nafssiti-primary transition">
                        <span class="text-xs font-semibold text-slate-600">14:00 - 18:00</span>
                        <button class="text-slate-300 hover:text-nafssiti-accent transition"><i class="fas fa-times-circle text-sm"></i></button>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 border-dashed rounded-sm p-6 text-center opacity-60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">Mercredi : Aucun créneau défini</span>
            </div>
        </div>
    </div>
@endsection
