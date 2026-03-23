@extends('admin.layouts.app')

@section('title', 'Gestion des Spécialités | NAFSSITI PRO')

@section('page_title', 'Gestion des Spécialités')

@section('content')
    <div class="mb-8">
        <div class="bg-white p-8 border-b-4 border-nafssiti-primary shadow-sm rounded-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-nafssiti-primary/10 rounded flex items-center justify-center text-nafssiti-primary">
                    <i class="fas fa-plus-circle text-lg"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 uppercase tracking-widest text-sm italic">Nouvelle Spécialité</h3>
                    <p class="text-[10px] text-slate-400 uppercase tracking-tighter">Ajoutez une expertise pour vos praticiens</p>
                </div>
            </div>
            
            <form action="{{ route('admin.speciality.store') }}" method="POST" class="flex flex-col md:flex-row gap-4">
                @csrf
                <div class="flex-1">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-nafssiti-primary transition-colors">
                            <i class="fas fa-tag text-xs"></i>
                        </div>
                        <input type="text" name="name" placeholder="Désignation de la spécialité..." 
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded text-sm outline-none focus:ring-2 focus:ring-nafssiti-primary/20 focus:border-nafssiti-primary shadow-sm transition-all" required>
                    </div>
                    @error('name')
                        <span class="text-red-500 text-[10px] italic mt-2 block ml-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="px-8 py-3 bg-nafssiti-primary text-white text-[11px] font-bold uppercase tracking-widest rounded-sm hover:bg-[#3da3a3] transform hover:-translate-y-0.5 active:translate-y-0 transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i>
                    Enregistrer la spécialité
                </button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-sm text-sm font-medium flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 shadow-sm rounded-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="font-bold text-slate-800 uppercase tracking-widest text-[11px] flex items-center gap-2">
                <i class="fas fa-list-ul text-nafssiti-primary"></i>
                Catalogue des Spécialités
            </h3>
            <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[9px] font-bold uppercase tracking-wider">
                Total: {{ $specialities->count() }}
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-white text-slate-400 border-b border-slate-100 uppercase tracking-widest text-[9px] font-bold">
                        <th class="px-8 py-4">Référence</th>
                        <th class="px-8 py-4">Désignation Officielle</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($specialities as $speciality)
                        <tr class="group hover:bg-slate-50/80 transition-all duration-200">
                            <td class="px-8 py-5 font-mono text-slate-300 group-hover:text-nafssiti-primary transition-colors">#RF-{{ $speciality->id }}</td>
                            <td class="px-8 py-5 text-sm">
                                <span class="font-semibold text-slate-700 group-hover:text-slate-900 transition-colors">{{ $speciality->name }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex justify-end">
                                    <form action="{{ route('admin.speciality.destroy', $speciality->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette spécialité ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all shadow-sm border border-slate-100" title="Supprimer">
                                            <i class="fas fa-trash-alt text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="fas fa-folder-open text-3xl text-slate-200"></i>
                                    <p class="text-slate-400 italic font-light">Aucune spécialité enregistrée pour le moment.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
