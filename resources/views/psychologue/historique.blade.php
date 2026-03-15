@extends('layouts.psychologue')

@section('title', 'Historique des Séances | NAFSSITI Pro')
@section('header_title', 'Archive des Consultations')

@section('styles')
    <style>
        .timeline-line::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: repeating-linear-gradient(to bottom, #e2e8f0 0%, #e2e8f0 50%, transparent 50%, transparent 100%);
            background-size: 1px 10px;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="mb-12">
            <div class="flex items-center gap-4 mb-8">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-tighter">Mars 2026</h3>
                <div class="h-[1px] flex-1 bg-slate-200"></div>
            </div>

            <div class="relative timeline-line ml-4 space-y-8">
                <div class="relative pl-12 group">
                    <div class="absolute left-0 top-1 w-10 h-10 bg-white border-2 border-nafssiti-primary rounded-sm flex items-center justify-center z-10 shadow-sm group-hover:scale-110 transition">
                        <span class="text-[10px] font-bold text-nafssiti-primary uppercase">12</span>
                    </div>

                    <div class="bg-white p-6 border border-slate-200 rounded-sm shadow-sm hover:border-nafssiti-secondary transition flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <img src="https://ui-avatars.com/api/?name=Karim+I&background=f1f5f9&color=4dbfbf" class="w-12 h-12 rounded-sm grayscale group-hover:grayscale-0 transition">
                            <div>
                                <p class="text-xs font-bold text-slate-800">Karim Idrissi</p>
                                <p class="text-[10px] text-slate-400 font-medium">Session terminée à 15:45</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-10">
                            <div class="text-center">
                                <p class="text-[9px] font-bold text-slate-300 uppercase tracking-widest">Durée</p>
                                <p class="text-xs font-bold text-slate-600">45 min</p>
                            </div>
                            <div class="px-4 py-1.5 bg-slate-50 border border-slate-100 rounded-sm">
                                <span class="text-[9px] font-bold text-nafssiti-secondary uppercase tracking-tighter">
                                    <i class="fas fa-check-circle mr-1"></i> Terminée
                                </span>
                            </div>
                            <button class="text-slate-300 hover:text-nafssiti-primary transition">
                                <i class="fas fa-file-medical-alt text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="relative pl-12 group">
                    <div class="absolute left-0 top-1 w-10 h-10 bg-white border-2 border-slate-200 rounded-sm flex items-center justify-center z-10 shadow-sm group-hover:scale-110 transition">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">08</span>
                    </div>

                    <div class="bg-white p-6 border border-slate-200 rounded-sm shadow-sm hover:border-nafssiti-secondary transition flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <img src="https://ui-avatars.com/api/?name=Sara+L&background=f1f5f9&color=4dbfbf" class="w-12 h-12 rounded-sm grayscale group-hover:grayscale-0 transition">
                            <div>
                                <p class="text-xs font-bold text-slate-800">Sara Lemrani</p>
                                <p class="text-[10px] text-slate-400 font-medium">Session terminée à 11:00</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-10">
                            <div class="text-center">
                                <p class="text-[9px] font-bold text-slate-300 uppercase tracking-widest">Durée</p>
                                <p class="text-xs font-bold text-slate-600">60 min</p>
                            </div>
                            <div class="px-4 py-1.5 bg-slate-50 border border-slate-100 rounded-sm">
                                <span class="text-[9px] font-bold text-nafssiti-secondary uppercase tracking-tighter">
                                    <i class="fas fa-check-circle mr-1"></i> Terminée
                                </span>
                            </div>
                            <button class="text-slate-300 hover:text-nafssiti-primary transition">
                                <i class="fas fa-file-medical-alt text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center py-10">
            <button class="px-8 py-3 bg-white border border-slate-200 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] hover:bg-nafssiti-dark hover:text-white transition shadow-sm rounded-sm">
                Charger les séances précédentes
            </button>
        </div>
    </div>
@endsection
