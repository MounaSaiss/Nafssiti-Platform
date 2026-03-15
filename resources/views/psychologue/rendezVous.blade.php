@extends('layouts.psychologue')

@section('title', 'Mes Rendez-vous | NAFSSITI Pro')
@section('header_title', 'Gestion des Séances')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex gap-2">
            <button class="px-4 py-2 bg-nafssiti-dark text-white text-[10px] font-bold uppercase tracking-wider rounded-sm shadow-sm">Tous</button>
            <button class="px-4 py-2 bg-white border border-slate-200 text-slate-400 text-[10px] font-bold uppercase tracking-wider rounded-sm hover:border-nafssiti-primary transition">À venir</button>
            <button class="px-4 py-2 bg-white border border-slate-200 text-slate-400 text-[10px] font-bold uppercase tracking-wider rounded-sm hover:border-nafssiti-primary transition">En attente</button>
        </div>
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
            <input type="text" placeholder="Rechercher un patient..."
                class="pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-sm text-[11px] outline-none focus:border-nafssiti-primary w-64 transition">
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-8 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Patient</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Date & Heure</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Type / Notes</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Statut</th>
                    <th class="px-8 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <tr class="hover:bg-slate-50/50 transition group">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Karim+I&background=f1f5f9&color=4dbfbf" class="w-8 h-8 rounded-sm">
                            <div>
                                <p class="text-xs font-bold text-slate-800">Karim Idrissi</p>
                                <p class="text-[9px] text-slate-400 font-medium">Patient depuis 2025</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-xs font-bold text-slate-700">Aujourd'hui</p>
                        <p class="text-[10px] text-nafssiti-primary font-bold">14:00 - 14:45</p>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-[10px] text-slate-600 leading-relaxed max-w-xs truncate" title="Sujet : Gestion de l'anxiété post-confinement">
                            <i class="fas fa-comment-dots mr-1 text-slate-300"></i> Gestion de l'anxiété...
                        </p>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-green-50 text-nafssiti-secondary text-[9px] font-bold uppercase rounded-full border border-green-100">Confirmé</span>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <button class="text-[10px] font-bold text-nafssiti-primary uppercase tracking-tighter hover:underline">Détails</button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50/50 transition group">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Sara+L&background=f1f5f9&color=4dbfbf" class="w-8 h-8 rounded-sm">
                            <div>
                                <p class="text-xs font-bold text-slate-800">Sara Lemrani</p>
                                <p class="text-[9px] text-slate-400 font-medium">Nouveau Patient</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-xs font-bold text-slate-700">Aujourd'hui</p>
                        <p class="text-[10px] text-nafssiti-primary font-bold">16:30 - 17:15</p>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-[10px] text-slate-600 italic">Première consultation vidéo</p>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-amber-50 text-amber-500 text-[9px] font-bold uppercase rounded-full border border-amber-100">En attente</span>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <button class="text-[10px] font-bold text-nafssiti-primary uppercase tracking-tighter hover:underline">Détails</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-between items-center px-2">
        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wider italic">Affichage de 2 sur 12 rendez-vous</p>
        <div class="flex gap-1">
            <button class="w-8 h-8 flex items-center justify-center bg-white border border-slate-200 rounded-sm text-xs text-slate-400 hover:text-nafssiti-primary transition"><i class="fas fa-chevron-left"></i></button>
            <button class="w-8 h-8 flex items-center justify-center bg-white border border-slate-200 rounded-sm text-xs text-slate-400 hover:text-nafssiti-primary transition"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
@endsection
