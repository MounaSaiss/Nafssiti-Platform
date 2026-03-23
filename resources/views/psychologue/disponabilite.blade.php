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

                <form action="{{ route('psychologue.storeDisponabilite') }}" method="POST" class="space-y-5">
                    @csrf
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-100 text-nafssiti-secondary text-[10px] font-bold p-3 rounded-sm">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-50 border border-red-100 text-red-500 text-[10px] font-bold p-3 rounded-sm">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="bg-red-50 border border-red-100 text-red-500 text-[10px] font-bold p-3 rounded-sm">
                            <ul class="list-disc pl-4">
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
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">De (Heure)</label>
                            <input type="time" name="start_time" required
                                class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">À (Heure)</label>
                            <input type="time" name="end_time" required
                                class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
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
                <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Mes Horaires de Consultation</h3>
                <span class="text-[9px] text-slate-400 font-medium italic">Consultez vos créneaux définis</span>
            </div>

            @forelse($availabilities as $day => $slots)
            <div class="bg-white border border-slate-200 rounded-sm overflow-hidden shadow-sm">
                <div class="bg-slate-50 px-6 py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="text-xs font-bold text-slate-700 uppercase tracking-tight">{{ $day }}</span>
                    <span class="text-[9px] bg-nafssiti-primary/10 text-nafssiti-primary px-2 py-1 rounded-full font-bold">
                        {{ $slots->count() }} Créneau{{ $slots->count() > 1 ? 'x' : '' }}
                    </span>
                </div>
                <div class="p-6 flex flex-wrap gap-4">
                    @foreach($slots as $slot)
                    <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 px-4 py-2 rounded-sm group hover:border-nafssiti-primary transition">
                        <span class="text-xs font-semibold text-slate-600">
                            {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                        </span>
                        <p class="text-[10px] text-slate-400 font-medium italic">({{ \Carbon\Carbon::parse($slot->date)->format('d/m') }})</p>
                        <form action="{{ route('psychologue.destroyDisponabilite', $slot->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce créneau ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-300 hover:text-nafssiti-accent transition" title="Supprimer">
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
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">Aucun créneau défini pour le moment</p>
                <p class="text-slate-400 text-xs mt-1">Utilisez le formulaire à gauche pour ajouter vos disponibilités.</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection
