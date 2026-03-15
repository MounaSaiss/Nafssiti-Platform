@extends('layouts.psychologue')

@section('title', 'Profil Professionnel | NAFSSITI')
@section('header_title', 'Configuration du Profil Professionnel')

@section('content')
    <div class="max-w-4xl mx-auto">
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="bg-white rounded-sm border border-slate-200 p-8 mb-8 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-nafssiti-primary"></div>
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="relative group">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Mouna Tazi') }}&background=4dbfbf&color=fff&size=128"
                            class="w-32 h-32 rounded-sm object-cover border-4 border-slate-50 shadow-sm">
                        <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition cursor-pointer text-white text-xs font-bold uppercase tracking-tighter">
                            <i class="fas fa-camera mr-2"></i> Changer
                            <input type="file" class="hidden">
                        </label>
                    </div>
                    <div class="flex-1 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nom complet</label>
                                <input type="text" value="{{ Auth::user()->name ?? 'Dr. Mouna Tazi' }}"
                                    class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-2 text-sm focus:border-nafssiti-primary outline-none transition">
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Spécialité principale</label>
                                <input type="text" value="Psychologue clinicienne"
                                    class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-2 text-sm focus:border-nafssiti-primary outline-none transition">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Ville d'exercice</label>
                                <select class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-2 text-sm focus:border-nafssiti-primary outline-none transition">
                                    <option selected>Casablanca</option>
                                    <option>Rabat</option>
                                    <option>Marrakech</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Années d'expérience</label>
                                <input type="number" value="12"
                                    class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-2 text-sm focus:border-nafssiti-primary outline-none transition">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-sm border border-slate-200 p-8 shadow-sm space-y-8">
                <div>
                    <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600 mb-4 flex items-center gap-2">
                        <i class="fas fa-quote-left text-nafssiti-primary"></i> Description professionnelle
                    </h3>
                    <textarea rows="6"
                        class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs leading-relaxed focus:border-nafssiti-primary outline-none transition resize-none"
                        placeholder="Décrivez votre approche thérapeutique...">Spécialisée dans les thérapies cognitives et comportementales (TCC), j'accompagne mes patients dans la gestion de l'anxiété, du stress et des troubles émotionnels. Mon approche est basée sur l'écoute active et la bienveillance pour créer un espace de confiance.</textarea>
                </div>

                <hr class="border-slate-50">

                <div>
                    <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600 mb-4 flex items-center gap-2">
                        <i class="fas fa-graduation-cap text-nafssiti-primary"></i> Parcours & Expérience détaillée
                    </h3>
                    <textarea rows="4"
                        class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs leading-relaxed focus:border-nafssiti-primary outline-none transition resize-none"
                        placeholder="Diplômes, formations, anciens postes...">- Doctorat en Psychologie Clinique (Université Paris Descartes)&#10;- Certification en TCC (Thérapies Cognitives et Comportementales)&#10;- 5 ans au CHU de Casablanca</textarea>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end gap-4">
                    <button type="button" class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-slate-600 transition">Annuler</button>
                    <button type="submit" class="px-10 py-4 bg-nafssiti-dark text-white rounded-sm text-[10px] font-bold uppercase tracking-widest hover:bg-nafssiti-primary transition shadow-md">Sauvegarder le profil</button>
                </div>
            </div>
        </form>
    </div>
@endsection
