@extends('layouts.psychologue')

@section('title', 'Gestion des Indisponibilités | NAFSSITI')
@section('header_title', "Gestion de l'Emploi du temps (Absences & Pauses)")

@section('content')
    {{-- Messages de retour (Ajout / Suppression) --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-100 text-nafssiti-secondary text-xs font-bold p-4 rounded-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('delete_success'))
        <div class="mb-6 bg-red-50 border border-red-100 text-red-500 text-xs font-bold p-4 rounded-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-trash-alt"></i>
            {{ session('delete_success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-100 text-red-500 text-xs font-bold p-4 rounded-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="bg-white p-6 border border-slate-200 rounded-sm shadow-sm sticky top-28">
                <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600 mb-6 flex items-center gap-2">
                    <i class="fas fa-minus-circle text-nafssiti-accent"></i> Signaler une Indisponibilité
                </h3>

                <p class="text-[10px] text-slate-400 mb-6 leading-relaxed">
                    Note : Votre planning par défaut est : <strong>Lun-Ven (09:00 - 18:00)</strong>, <strong>Sam (09:00 - 14:00)</strong>. Le dimanche est chômé. Ajoutez ici vos pauses ou absences pour bloquer d'autres créneaux.
                </p>

                <form action="{{ route('psychologue.storeDisponabilite') }}" method="POST" class="space-y-5">
                    @csrf
                    @if($errors->any())
                        <div class="bg-red-50 border border-red-100 text-red-500 text-[10px] font-bold p-3 rounded-sm">
                            <ul class="list-disc pl-4 font-medium">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Date</label>
                        <input type="date" name="date" min="{{ date('Y-m-d') }}" required
                            class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Début</label>
                            <input type="time" name="start_time" required
                                class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Fin</label>
                            <input type="time" name="end_time" required
                                class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-nafssiti-accent text-white rounded-sm text-[10px] font-bold uppercase tracking-widest hover:bg-nafssiti-dark transition shadow-md">
                        Bloquer ce créneau
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Mes Temps d'Absence & Pauses</h3>
                <span class="text-[9px] text-slate-400 font-medium italic">Créneaux où vous n'êtes pas réservable</span>
            </div>

            @forelse($unavailabilities as $day => $slots)
            <div class="bg-white border border-slate-200 rounded-sm overflow-hidden shadow-sm">
                <div class="bg-slate-50 px-6 py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="text-xs font-bold text-slate-700 uppercase tracking-tight">{{ \Carbon\Carbon::parse($day)->translatedFormat('l d F') }}</span>
                    <span class="text-[9px] bg-nafssiti-accent/10 text-nafssiti-accent px-2 py-1 rounded-full font-bold">
                        {{ $slots->count() }} Blocage{{ $slots->count() > 1 ? 's' : '' }}
                    </span>
                </div>
                <div class="p-6 flex flex-wrap gap-4">
                    @foreach($slots as $slot)
                    <div class="flex items-center gap-3 bg-red-50/30 border border-red-100 px-4 py-2 rounded-sm group hover:border-nafssiti-accent transition">
                        <span class="text-xs font-semibold text-red-700">
                            {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                        </span>
                        <p class="text-[10px] text-red-300 font-medium italic">({{ \Carbon\Carbon::parse($slot->date)->format('d/m') }})</p>
                        <form action="{{ route('psychologue.destroyDisponabilite', $slot->id) }}" method="POST" onsubmit="return confirm('Voulez-vous redevenir disponible sur ce créneau ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600 transition" title="Supprimer le blocage">
                                <i class="fas fa-times-circle text-sm"></i>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @empty
            <div class="bg-white border border-slate-200 border-dashed rounded-sm p-12 text-center">
                <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">Aucun blocage - Vous êtes disponible 08:00 - 20:00</p>
                <p class="text-slate-400 text-xs mt-1">Utilisez le formulaire à gauche pour bloquer des moments spécifiques.</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection
