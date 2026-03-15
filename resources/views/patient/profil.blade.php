@extends('layouts.patient')

@section('title', 'Paramètres Profil | NAFSSITI')
@section('header_title', 'Paramètres du compte')

@section('content')
    <div class="max-w-4xl">
        <div class="mb-8">
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Mon Profil</h1>
            <p class="text-slate-400 text-xs mt-1 font-medium">Gérez vos informations personnelles et vos préférences de sécurité.</p>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="bg-white border border-slate-200 rounded-sm p-6 shadow-sm">
                <div class="flex items-center gap-6">
                    <div class="relative group">
                        <img id="preview" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Karim Idrissi') }}&background=f1f5f9&color=4dbfbf" class="w-20 h-20 rounded-sm object-cover border border-slate-100">
                        <label for="avatar" class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer rounded-sm">
                            <i class="fas fa-camera text-white text-xs"></i>
                        </label>
                        <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*">
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-widest">Photo de profil</h3>
                        <p class="text-[10px] text-slate-400 mt-1">JPG, PNG ou GIF. Max 2Mo.</p>
                        <button type="button" class="mt-2 text-[10px] font-bold text-nafssiti-primary uppercase tracking-tighter hover:underline">Supprimer la photo</button>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-sm p-8 shadow-sm">
                <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600 mb-8 flex items-center gap-2">
                    <i class="fas fa-user-circle"></i> Informations personnelles
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Nom Complet</label>
                        <input type="text" name="name" value="{{ Auth::user()->name ?? 'Karim Idrissi' }}" 
                            class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Adresse Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email ?? 'karim.idrissi@example.com' }}" 
                            class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Téléphone</label>
                        <input type="tel" name="phone" value="{{ Auth::user()->phone ?? '+212 600 000 000' }}" 
                            class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Ville</label>
                        <select name="city" class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                            <option>Casablanca</option>
                            <option>Rabat</option>
                            <option>Marrakech</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-sm p-8 shadow-sm">
                <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600 mb-8 flex items-center gap-2">
                    <i class="fas fa-lock"></i> Sécurité du compte
                </h3>
                
                <div class="space-y-6 max-w-md">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Nouveau mot de passe</label>
                        <input type="password" name="password" placeholder="••••••••"
                            class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••"
                            class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4">
                <button type="button" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-slate-600 transition">Annuler</button>
                <button type="submit" class="px-10 py-4 bg-nafssiti-dark text-white rounded-sm text-[10px] font-bold uppercase tracking-widest hover:bg-nafssiti-primary transition shadow-md">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
@endsection