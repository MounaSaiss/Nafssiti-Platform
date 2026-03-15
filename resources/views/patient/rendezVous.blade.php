@extends('layouts.patient')

@section('title', 'Mes Rendez-vous | NAFSSITI')
@section('header_title', 'Gestion de mes séances')

@section('content')
    <div class="mb-8">
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">Historique & Planning</h1>
        <p class="text-slate-400 text-xs mt-1 font-medium">Consultez, gérez ou annulez vos rendez-vous en cours.</p>
    </div>

    <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Date & Heure</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Psychologue</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Statut</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-5">
                        <p class="text-xs font-bold text-slate-700">18 Mars 2026</p>
                        <p class="text-[10px] text-slate-400 font-medium">14:30 (45 min)</p>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Mouna+Tazi&background=4dbfbf&color=fff" class="w-7 h-7 rounded-sm">
                            <div>
                                <p class="text-xs font-bold text-slate-700">Dr. Mouna Tazi</p>
                                <p class="text-[9px] text-nafssiti-primary font-bold uppercase tracking-tighter">Clinique</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="px-3 py-1 bg-green-50 text-nafssiti-secondary text-[9px] font-bold uppercase rounded-full border border-green-100">Confirmé</span>
                    </td>
                    <td class="px-6 py-5 text-right">
                        <button class="text-[10px] font-bold text-red-400 uppercase tracking-widest hover:text-red-600 transition flex items-center gap-2 ml-auto" title="Annuler le rendez-vous">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-5">
                        <p class="text-xs font-bold text-slate-700">25 Mars 2026</p>
                        <p class="text-[10px] text-slate-400 font-medium">10:00 (45 min)</p>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Amine+B&background=96d14b&color=fff" class="w-7 h-7 rounded-sm">
                            <div>
                                <p class="text-xs font-bold text-slate-700">Dr. Amine Bennani</p>
                                <p class="text-[9px] text-nafssiti-primary font-bold uppercase tracking-tighter">TCC</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="px-3 py-1 bg-amber-50 text-amber-500 text-[9px] font-bold uppercase rounded-full border border-amber-100">En attente</span>
                    </td>
                    <td class="px-6 py-5 text-right">
                        <button class="text-[10px] font-bold text-red-400 uppercase tracking-widest hover:text-red-600 transition flex items-center gap-2 ml-auto">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                    </td>
                </tr>

                <tr class="opacity-60 bg-slate-50/30">
                    <td class="px-6 py-5">
                        <p class="text-xs font-bold text-slate-500">10 Mars 2026</p>
                        <p class="text-[10px] text-slate-400 font-medium italic">Terminé</p>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Mouna+Tazi&background=CBD5E1&color=fff" class="w-7 h-7 rounded-sm grayscale">
                            <p class="text-xs font-bold text-slate-500">Dr. Mouna Tazi</p>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="px-3 py-1 bg-slate-100 text-slate-400 text-[9px] font-bold uppercase rounded-full border border-slate-200">Effectué</span>
                    </td>
                    <td class="px-6 py-5 text-right italic text-[10px] text-slate-400">Aucune action</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex items-center gap-3 bg-blue-50/50 p-4 border border-blue-100 rounded-sm">
        <i class="fas fa-info-circle text-blue-400 text-xs"></i>
        <p class="text-[10px] text-blue-600 font-medium">Les annulations doivent être effectuées au moins 24 heures à l'avance pour être éligibles à un remboursement ou report.</p>
    </div>
@endsection
