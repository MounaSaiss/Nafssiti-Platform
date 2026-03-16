@extends('layouts.patient')

@section('title', 'Réserver une Séance | NAFSSITI')
@section('header_title', 'Formulaire de Réservation')

@section('styles')
    <style>
        .psy-list::-webkit-scrollbar {
            width: 4px;
        }
        .psy-list::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .psy-list::-webkit-scrollbar-thumb {
            background: #4dbfbf;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-5xl">
        <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
            <form action="#" method="POST" class="p-8 space-y-12">
                @csrf
                <section>
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 bg-nafssiti-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-sm">1</span>
                            <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Sélectionner votre psychologue</h3>
                        </div>
                        <div class="relative w-full md:w-72">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                            <input type="text" placeholder="Rechercher par nom..."
                                class="w-full bg-slate-50 border border-slate-100 rounded-sm py-2.5 pl-9 pr-4 text-[11px] outline-none focus:border-nafssiti-primary transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 max-h-64 overflow-y-auto pr-2 psy-list">
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="psychologist_id" class="peer sr-only" checked>
                            <div class="p-3 border border-slate-100 rounded-sm bg-slate-50 peer-checked:bg-white peer-checked:border-nafssiti-primary peer-checked:ring-1 peer-checked:ring-nafssiti-primary transition-all flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Mouna+Tazi&background=4dbfbf&color=fff" class="w-9 h-9 rounded-sm">
                                <div>
                                    <p class="text-[11px] font-bold text-slate-800">Dr. Mouna Tazi</p>
                                    <p class="text-[9px] text-slate-400 font-medium uppercase tracking-tighter">Psychologue clinicienne</p>
                                </div>
                            </div>
                            <div class="absolute top-2 right-2 w-3 h-3 border border-slate-300 rounded-full peer-checked:bg-nafssiti-primary peer-checked:border-nafssiti-primary transition"></div>
                        </label>
                    
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="psychologist_id" class="peer sr-only">
                            <div class="p-3 border border-slate-100 rounded-sm bg-slate-50 peer-checked:bg-white peer-checked:border-nafssiti-primary peer-checked:ring-1 peer-checked:ring-nafssiti-primary transition-all flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Amine+B&background=96d14b&color=fff" class="w-9 h-9 rounded-sm">
                                <div>
                                    <p class="text-[11px] font-bold text-slate-800">Dr. Amine Bennani</p>
                                    <p class="text-[9px] text-slate-400 font-medium uppercase tracking-tighter">Thérapeute TCC</p>
                                </div>
                            </div>
                            <div class="absolute top-2 right-2 w-3 h-3 border border-slate-300 rounded-full peer-checked:bg-nafssiti-primary peer-checked:border-nafssiti-primary transition"></div>
                        </label>

                        <label class="relative cursor-pointer group">
                            <input type="radio" name="psychologist_id" class="peer sr-only">
                            <div class="p-3 border border-slate-100 rounded-sm bg-slate-50 peer-checked:bg-white peer-checked:border-nafssiti-primary peer-checked:ring-1 peer-checked:ring-nafssiti-primary transition-all flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Sara+M&background=0f172a&color=fff" class="w-9 h-9 rounded-sm">
                                <div>
                                    <p class="text-[11px] font-bold text-slate-800">Dr. Sara Mansouri</p>
                                    <p class="text-[9px] text-slate-400 font-medium uppercase tracking-tighter">Couple & Famille</p>
                                </div>
                            </div>
                            <div class="absolute top-2 right-2 w-3 h-3 border border-slate-300 rounded-full peer-checked:bg-nafssiti-primary peer-checked:border-nafssiti-primary transition"></div>
                        </label>
                    </div>
                </section>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <section>
                        <div class="flex items-center gap-3 mb-6">
                            <span class="w-6 h-6 bg-nafssiti-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center">2</span>
                            <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Choisir la date</h3>
                        </div>
                        <input type="date" name="date"
                            class="w-full bg-slate-50 border border-slate-200 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                    </section>

                    <section>
                        <div class="flex items-center gap-3 mb-6">
                            <span class="w-6 h-6 bg-nafssiti-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center">3</span>
                            <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Heures disponibles</h3>
                        </div>
                        <div class="grid grid-cols-4 gap-2">
                            <button type="button" class="py-2.5 border border-slate-200 rounded-sm text-[10px] font-bold hover:border-nafssiti-primary transition focus:bg-nafssiti-primary focus:text-white">09:00</button>
                            <button type="button" class="py-2.5 border border-slate-200 rounded-sm text-[10px] font-bold hover:border-nafssiti-primary transition focus:bg-nafssiti-primary focus:text-white">10:00</button>
                            <button type="button" class="py-2.5 border border-slate-200 rounded-sm text-[10px] font-bold hover:border-nafssiti-primary transition focus:bg-nafssiti-primary focus:text-white">14:00</button>
                            <button type="button" class="py-2.5 border border-slate-200 rounded-sm text-[10px] font-bold hover:border-nafssiti-primary transition focus:bg-nafssiti-primary focus:text-white">16:00</button>
                        </div>
                    </section>
                </div>

                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-6 h-6 bg-nafssiti-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center">4</span>
                        <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Notes pour le praticien</h3>
                    </div>
                    <textarea name="notes" rows="4"
                        placeholder="Avez-vous des points spécifiques que vous aimeriez aborder lors de cette séance ?"
                        class="w-full bg-slate-50 border border-slate-200 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition resize-none"></textarea>
                </section>

                <div class="pt-6 border-t border-slate-100 flex justify-end items-center gap-6">
                    <span class="text-[10px] text-slate-400 font-medium uppercase tracking-tighter italic">Paiement à la séance : 300 DH</span>
                    <button type="submit"
                        class="px-12 py-4 bg-nafssiti-dark text-white rounded-sm text-[10px] font-bold uppercase tracking-widest hover:bg-nafssiti-secondary transition shadow-md">
                        Confirmer la réservation
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
