@extends('layouts.psychologue')

@section('title', 'Dossier Patient | ' . ($patient->user->name ?? 'Patient'))

@section('content')
<div class="max-w-[850px] mx-auto min-h-screen bg-[#f8fafc] pb-10">
    
    <!-- HEADER ULTRA-COMPACT -->
    <header class="flex items-center justify-between mb-6 bg-white border border-slate-200 px-5 py-3 rounded-lg shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-nafssiti-primary/10 text-nafssiti-primary rounded flex items-center justify-center text-sm">
                <i class="fas fa-folder-open"></i>
            </div>
            <div>
                <h1 class="text-[13px] font-bold text-slate-800 leading-none">Dossier Clinique</h1>
                <p class="text-[10px] text-slate-400 mt-1 uppercase font-bold tracking-tight">Patient : {{ $patient->user->name }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right border-r border-slate-100 pr-4 hidden md:block">
                <p class="text-[9px] font-extrabold text-slate-300 uppercase tracking-widest">Initié le</p>
                <p class="text-[11px] font-bold text-slate-600">{{ $patient->suivi_start_date ? \Carbon\Carbon::parse($patient->suivi_start_date)->translatedFormat('d M Y') : '--' }}</p>
            </div>
            <span class="px-2 py-0.5 bg-green-50 text-green-600 text-[10px] font-bold rounded border border-green-100">ACTIF</span>
        </div>
    </header>

    <div class="space-y-6">
        
        <!-- 1. OBJECTIFS (TOP) -->
        <section class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
            <header class="px-5 py-3 border-b border-slate-50 bg-slate-50/30 flex items-center justify-between">
                <h2 class="text-[12px] font-bold text-slate-700 flex items-center gap-2 uppercase tracking-wide">
                    <i class="fas fa-bullseye text-nafssiti-primary text-[10px]"></i> Objectifs du Suivi
                </h2>
                <span class="text-[10px] font-bold text-slate-400 opacity-60 bg-white px-2 py-0.5 rounded border border-slate-100">
                    {{ $objectives->where('status', 'en cours')->count() }} Actifs
                </span>
            </header>
            <div class="p-6">
                <form action="{{ route('psychologue.shared_room.storeObjective', $patient->id) }}" method="POST" class="flex gap-2 mb-6">
                    @csrf
                    <input type="text" name="description" placeholder="Nouvel objectif..." 
                           class="flex-1 px-3 py-2 text-[11px] border-slate-200 rounded focus:ring-1 focus:ring-nafssiti-primary bg-slate-50" required>
                    <button type="submit" class="bg-slate-800 text-white px-4 py-2 text-[11px] font-bold rounded uppercase tracking-wider hover:bg-black transition">Ajouter</button>
                </form>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @forelse($objectives as $obj)
                        <div class="flex items-center justify-between p-3 {{ $obj->status === 'atteint' ? 'bg-slate-50 opacity-40' : 'bg-white border border-slate-100 hover:border-nafssiti-primary/30' }} rounded transition-colors group">
                            <div class="flex items-center gap-3">
                                <form action="{{ route('psychologue.shared_room.updateObjectiveStatus', $obj->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-4 h-4 rounded-full border border-slate-300 flex items-center justify-center text-[8px] {{ $obj->status === 'atteint' ? 'bg-nafssiti-secondary border-nafssiti-secondary text-white' : 'text-transparent hover:border-nafssiti-secondary' }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <span class="text-[11px] {{ $obj->status === 'atteint' ? 'text-slate-400 line-through' : 'text-slate-600 font-medium' }}">{{ $obj->description }}</span>
                            </div>
                            <form action="{{ route('psychologue.shared_room.destroyObjective', $obj->id) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-200 hover:text-red-400 px-1"><i class="fas fa-trash-alt text-[10px]"></i></button>
                            </form>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-6 border border-dashed border-slate-100 rounded">
                            <p class="text-[11px] text-slate-400 italic">Aucun objectif.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- 2. CONSEILS -->
        <section class="bg-white border border-slate-200 rounded-lg shadow-sm">
            <header class="px-5 py-3 border-b border-slate-50 bg-slate-50/30">
                <h2 class="text-[12px] font-bold text-slate-700 uppercase tracking-wide flex items-center gap-2">
                    <i class="fas fa-hand-holding-heart text-nafssiti-secondary text-[10px]"></i> Conseils Partagés
                </h2>
            </header>
            <div class="p-6">
                <form action="{{ route('psychologue.shared_room.storeRecommendation', $patient->id) }}" method="POST" class="mb-6">
                    @csrf
                    <div class="bg-slate-50 border border-slate-200 rounded overflow-hidden">
                        <textarea name="content" rows="2" placeholder="Un exercice ou conseil..." 
                                  class="w-full bg-transparent border-none text-[11px] text-slate-600 placeholder-slate-400 focus:ring-0 p-3 resize-none leading-relaxed" required></textarea>
                        <div class="flex justify-end p-2 border-t border-slate-100 bg-white/30">
                            <button type="submit" class="bg-nafssiti-secondary text-white px-4 py-1.5 text-[10px] font-bold rounded uppercase tracking-widest hover:bg-green-600 transition">Partager</button>
                        </div>
                    </div>
                </form>

                <div class="space-y-3">
                    @foreach($recommendations as $rec)
                        <div class="group relative bg-white border border-slate-100 p-4 rounded hover:bg-slate-50/30 transition-all">
                            <p class="text-[11px] text-slate-500 leading-relaxed pr-8">{{ $rec->content }}</p>
                            <div class="mt-3 flex items-center justify-between border-t border-slate-50 pt-2">
                                <span class="text-[9px] text-slate-300 font-bold uppercase">{{ $rec->created_at->format('d/m/Y') }}</span>
                                <form action="{{ route('psychologue.shared_room.destroyRecommendation', $rec->id) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-200 hover:text-red-400 text-[10px] font-bold uppercase">Effacer</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- 3. INFOS & RDV -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="p-4 border-b border-slate-50 flex items-center justify-between">
                    <h2 class="text-[12px] font-bold text-slate-700 uppercase tracking-wide">Patient Profile</h2>
                </div>
                <div class="p-5">
                    <div id="patient-info-display" class="space-y-4">
                        <div class="p-3 bg-slate-50 rounded border border-slate-100 italic text-[11px] text-slate-600">
                            "{{ $patient->problematique_principale ?? 'Détail en attente.' }}"
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-300 uppercase">Âge</label>
                                <p class="text-[11px] text-slate-700 font-bold leading-none mt-1">{{ $patient->age ? $patient->age . ' ans' : '--' }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-300 uppercase">Code</label>
                                <p class="text-[10px] text-slate-400 leading-none mt-1">#{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                        <button onclick="toggleEditInfo()" class="w-full text-slate-400 hover:text-nafssiti-primary py-1 text-[10px] font-bold uppercase transition mt-2">ÉDITER</button>
                    </div>

                    <form id="patient-info-edit" action="{{ route('psychologue.shared_room.updatePatientInfo', $patient->id) }}" method="POST" class="hidden space-y-3">
                        @csrf
                        <input type="date" name="date_of_birth" value="{{ $patient->date_of_birth }}" class="w-full border-slate-200 rounded text-[11px] p-2 bg-slate-50">
                        <textarea name="problematique_principale" rows="3" class="w-full border-slate-200 rounded text-[11px] p-2 bg-slate-50">{{ $patient->problematique_principale }}</textarea>
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 bg-slate-800 text-white py-2 text-[11px] font-bold rounded">OK</button>
                            <button type="button" onclick="toggleEditInfo()" class="flex-1 bg-slate-100 text-slate-500 py-2 text-[11px] font-bold rounded">NON</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="p-4 border-b border-slate-50 flex items-center justify-between">
                    <h2 class="text-[12px] font-bold text-slate-700 uppercase tracking-wide">Agenda</h2>
                </div>
                <div class="p-5">
                    <div class="space-y-2">
                        @forelse($upcomingAppointments as $apt)
                            <div class="flex items-center gap-3 p-2 bg-slate-50/30 rounded border border-slate-100">
                                <div class="w-7 h-7 rounded bg-white border border-slate-200 flex flex-col items-center justify-center shrink-0">
                                    <span class="text-[10px] font-bold text-nafssiti-primary leading-none">{{ \Carbon\Carbon::parse($apt->appointmentDate)->format('d') }}</span>
                                    <span class="text-[7px] font-bold text-slate-300 uppercase mt-0.5">{{ \Carbon\Carbon::parse($apt->appointmentDate)->translatedFormat('M') }}</span>
                                </div>
                                <div class="flex-1 flex items-center justify-between">
                                    <p class="text-[11px] font-bold text-slate-600">Séance</p>
                                    <p class="text-[10px] text-slate-400 italic">à {{ \Carbon\Carbon::parse($apt->appointmentTime)->format('H:i') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-[10px] text-slate-300 text-center italic py-2">Aucun RDV.</p>
                        @endforelse
                    </div>
                    <form action="{{ route('psychologue.shared_room.storeAppointment', $patient->id) }}" method="POST" class="mt-4 pt-4 border-t border-slate-50 space-y-2">
                        @csrf
                        <div class="flex gap-2">
                            <input type="date" name="appointmentDate" class="text-[10px] border-slate-200 rounded flex-1 bg-slate-50 p-1.5" required>
                            <input type="time" name="appointmentTime" class="text-[10px] border-slate-200 rounded w-20 bg-slate-50 p-1.5" required>
                        </div>
                        <button type="submit" class="w-full bg-nafssiti-primary text-white py-2 text-[11px] font-bold uppercase rounded hover:opacity-90">Planifier</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    body { background-color: #f8fafc; }
    .custom-scrollbar::-webkit-scrollbar { width: 2px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    
    /* Global Compact Font Factor */
    * { 
        font-family: 'Rubik', sans-serif; 
        -webkit-font-smoothing: antialiased;
    }
</style>

<script>
    function toggleEditInfo() {
        const display = document.getElementById('patient-info-display');
        const edit = document.getElementById('patient-info-edit');
        display.classList.toggle('hidden');
        edit.classList.toggle('hidden');
    }
</script>
@endsection
