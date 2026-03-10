@extends('admin.layouts.app')

@section('title', 'Gestion Utilisateurs | NAFSSITI PRO')

@section('page_title', 'Annuaire Utilisateurs')

@section('header_actions')
    <div class="flex items-center gap-4">
        <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded font-bold uppercase tracking-widest">Total
            : 1,284</span>
    </div>
@endsection

@section('content')
    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <div class="relative flex-1">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" placeholder="Rechercher par nom, email, ville..."
                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded shadow-sm text-sm focus:ring-1 focus:ring-nafssiti-primary outline-none transition">
        </div>
        <select
            class="bg-white border border-slate-200 px-4 py-2.5 rounded text-xs font-bold uppercase tracking-tight text-slate-600 outline-none cursor-pointer">
            <option>Tous les rôles</option>
            <option>Patients</option>
            <option>Psychologues</option>
        </select>
        <button
            class="bg-nafssiti-primary text-white px-6 py-2.5 rounded font-bold text-xs uppercase hover:bg-teal-600 transition shadow-sm">
            <i class="fas fa-plus mr-2"></i> Nouvel Utilisateur
        </button>
    </div>

    <div class="bg-white border border-slate-200 shadow-sm rounded-sm overflow-hidden">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 uppercase tracking-widest border-b border-slate-200">
                    <th class="px-6 py-4 font-bold">Utilisateur</th>
                    <th class="px-6 py-4 font-bold">Rôle</th>
                    <th class="px-6 py-4 font-bold">Ville</th>
                    <th class="px-6 py-4 font-bold text-center">Statut</th>
                    <th class="px-6 py-4 font-bold text-right">Actions de Contrôle</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Karim+Idrissi&background=4dbfbf&color=fff"
                                class="w-8 h-8 rounded-full shadow-sm">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-900 uppercase tracking-tight">Karim Idrissi</span>
                                <span class="text-slate-400 text-[10px]">karim.idr@email.com</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span
                            class="text-[10px] font-bold text-slate-500 border border-slate-200 px-2 py-0.5 rounded uppercase">Patient</span>
                    </td>
                    <td class="px-6 py-4 font-medium text-slate-700">Casablanca</td>
                    <td class="px-6 py-4 text-center">
                        <span
                            class="inline-flex items-center gap-1.5 text-green-600 font-bold uppercase text-[9px] bg-green-50 px-2 py-1 rounded border border-green-100">
                            Actif
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-2 items-center">
                            <button
                                class="flex items-center justify-center gap-2 px-3 py-2 bg-slate-100 text-slate-700 rounded-sm font-bold uppercase text-[10px] hover:bg-slate-200 transition-all border border-slate-200 shadow-sm">
                                <i class="fas fa-eye"></i> Consulter
                            </button>
                            <button
                                class="w-28 flex items-center justify-center gap-2 px-3 py-2 bg-white text-nafssiti-red border border-nafssiti-red rounded-sm font-bold uppercase text-[10px] hover:bg-nafssiti-red hover:text-white transition-all shadow-sm">
                                <i class="fas fa-ban"></i> Bannir
                            </button>
                        </div>
                    </td>
                </tr>

                <tr class="bg-slate-50/50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3 opacity-60">
                            <img src="https://ui-avatars.com/api/?name=Ahmed+Tazi&background=64748b&color=fff"
                                class="w-8 h-8 rounded-full shadow-sm">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-900 uppercase tracking-tight">Ahmed Tazi</span>
                                <span class="text-slate-400 text-[10px]">a.tazi@email.com</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span
                            class="text-[10px] font-bold text-slate-400 border border-slate-200 px-2 py-0.5 rounded uppercase opacity-60">Patient</span>
                    </td>
                    <td class="px-6 py-4 font-medium text-slate-400">Marrakech</td>
                    <td class="px-6 py-4 text-center">
                        <span
                            class="inline-flex items-center gap-1.5 text-slate-500 font-bold uppercase text-[9px] bg-slate-100 px-2 py-1 rounded border border-slate-200">
                            Banni
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-2 items-center">
                            <button
                                class="flex items-center justify-center gap-2 px-3 py-2 bg-slate-100 text-slate-700 rounded-sm font-bold uppercase text-[10px] hover:bg-slate-200 transition-all border border-slate-200 shadow-sm">
                                <i class="fas fa-eye"></i> Consulter
                            </button>
                            <button
                                class="w-28 flex items-center justify-center gap-2 px-3 py-2 bg-white text-green-600 border border-green-600 rounded-sm font-bold uppercase text-[10px] hover:bg-green-600 hover:text-white transition-all shadow-sm">
                                <i class="fas fa-check"></i> Débannir
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
