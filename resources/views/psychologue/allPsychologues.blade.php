@extends('layouts.patient')

@section('title', 'Psychologues | NAFSSITI')
@section('header_title', 'Liste des Psychologues')

@section('content')
<div class="flex flex-col lg:flex-row gap-8">
    <aside class="w-full lg:w-1/4">
        <div class="bg-white p-5 rounded-sm border border-slate-200 shadow-sm sticky top-24">
            <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 mb-5">Filtrer par</h3>
            <div class="space-y-5">
                <form action="{{ route('psychologue.allPsychologues') }}" method="GET" class="space-y-5">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-2 uppercase">Spécialité</label>
                        <select name="specialty" class="w-full bg-slate-50 border border-slate-100 rounded-sm py-2 px-3 text-xs outline-none focus:border-nafssiti-primary transition">
                            <option value="">Toutes les spécialités</option>
                            @foreach($specialties as $specialty)
                                <option value="{{ $specialty }}" {{ request('specialty') == $specialty ? 'selected' : '' }}>
                                    {{ $specialty }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-2 uppercase">Ville</label>
                        <select name="city" class="w-full bg-slate-50 border border-slate-100 rounded-sm py-2 px-3 text-xs outline-none focus:border-nafssiti-primary transition">
                            <option value="">Toutes les villes</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full py-3 bg-nafssiti-dark text-white rounded-sm text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition shadow-md">
                        Rechercher
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <section class="w-full lg:w-3/4">
        <div class="grid md:grid-cols-2 gap-5">
            @forelse($psychologues as $psychologue)
            <div class="bg-white rounded-sm p-5 border border-slate-200 shadow-sm hover:border-nafssiti-primary/30 transition-all duration-300">
                <div class="flex items-start gap-4">
                    <div class="relative flex-shrink-0">
                        <img src="{{ $psychologue->photo ? asset('storage/' . $psychologue->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($psychologue->user->name) . '&background=4dbfbf&color=fff' }}"
                            class="w-16 h-16 rounded-sm object-cover"
                            alt="{{ $psychologue->user->name }}">
                        @if($psychologue->validationStatus === 'approved')
                        <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-nafssiti-secondary border-2 border-white rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-[7px] text-white"></i>
                        </div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-slate-800 tracking-tight">{{ $psychologue->user->name }}</h3>
                        <p class="text-nafssiti-primary text-[10px] font-medium uppercase mt-0.5">{{ $psychologue->specialization }}</p>

                        <div class="mt-2 flex items-center gap-3 text-slate-400">
                            <span class="text-[10px] flex items-center gap-1">
                                <i class="fas fa-map-marker-alt text-[9px]"></i> {{ $psychologue->city }}
                            </span>
                            <span class="text-[10px] flex items-center gap-1 border-l pl-3 border-slate-100">
                                <i class="fas fa-star text-amber-400 text-[9px]"></i> 5.0
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-50 flex items-center justify-between">
                    <div>
                        <p class="text-[9px] text-slate-400 uppercase font-bold tracking-tighter">Tarif séance</p>
                        <p class="text-sm font-bold text-slate-700">{{ $psychologue->pricePerSession }} DH</p>
                    </div>
                    <a href="#" class="px-4 py-2 bg-slate-50 text-slate-700 border border-slate-200 rounded-sm text-[9px] font-bold uppercase tracking-widest hover:bg-nafssiti-primary hover:text-white hover:border-nafssiti-primary transition-all">
                        Voir Profil
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-2 py-20 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <i class="fas fa-user-md text-2xl"></i>
                </div>
                <p class="text-slate-500 font-medium">Aucun psychologue trouvé.</p>
                <p class="text-slate-400 text-xs mt-1">Réessayez avec d'autres filtres.</p>
            </div>
            @endforelse
        </div>
    </section>
</div>
@endsection