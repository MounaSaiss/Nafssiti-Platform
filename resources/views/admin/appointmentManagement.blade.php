@extends('admin.layouts.app')

@section('title', 'Gestion des Rendez-vous | NAFSSITI PRO')

@section('page_title', 'Gestion des Rendez-vous')

@section('content')
    @if (session('success'))
        <div
            class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-sm text-sm font-medium flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div
            class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-sm text-sm font-medium flex items-center gap-3">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('admin.appointments.index') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
        <div class="relative flex-1 min-w-[300px]">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par patient ou psychologue..."
                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded text-sm outline-none focus:ring-1 focus:ring-nafssiti-primary shadow-sm transition">
        </div>
        <select name="status" onchange="this.form.submit()"
            class="bg-white border border-slate-200 px-4 py-2.5 rounded text-xs font-bold uppercase text-slate-600 outline-none cursor-pointer">
            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Tous les statuts</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Refusé</option>
        </select>
    </form>

    <div class="bg-white border border-slate-200 shadow-sm rounded-sm overflow-hidden">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 uppercase tracking-widest border-b border-slate-200">
                    <th class="px-6 py-4 font-bold uppercase tracking-widest border-b border-slate-200">Date de Création</th>
                    <th class="px-6 py-4 font-bold">Patient</th>
                    <th class="px-6 py-4 font-bold">Psychologue</th>
                    <th class="px-6 py-4 font-bold">Date & Heure RDV</th>
                    <th class="px-6 py-4 font-bold text-center">Statut</th>
                    <th class="px-6 py-4 font-bold text-right text-nafssiti-primary italic">Responsabilité</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($appointments as $appointment)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter bg-slate-50 px-2 py-1 rounded border border-slate-100">
                                {{ $appointment->created_at ? $appointment->created_at->format('d/m/Y') : 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span
                                    class="font-bold text-slate-900">{{ $appointment->patient->user->name ?? 'Patient Inconnu' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span
                                    class="font-bold text-nafssiti-primary uppercase">{{ $appointment->psychologist->user->name ?? 'Psychologue Inconnu' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span
                                    class="font-bold text-slate-700">{{ $appointment->appointmentDate ? \Carbon\Carbon::parse($appointment->appointmentDate)->translatedFormat('d F Y') : 'N/A' }}</span>
                                <span
                                    class="text-slate-500 italic text-[10px]">{{ $appointment->appointmentTime ? \Carbon\Carbon::parse($appointment->appointmentTime)->format('H:i') : 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusClasses = match($appointment->status) {
                                    'pending' => 'bg-amber-50 text-amber-500 border-amber-100',
                                    'confirmed' => 'bg-green-50 text-nafssiti-secondary border-green-100',
                                    'rejected' => 'bg-red-50 text-nafssiti-red border-red-100',
                                    default => 'bg-slate-50 text-slate-500 border-slate-100'
                                };
                                $statusLabel = match($appointment->status) {
                                    'pending' => 'En attente',
                                    'confirmed' => 'Confirmé',
                                    'rejected' => 'Refusé',
                                    default => $appointment->status
                                };
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold uppercase border {{ $statusClasses }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end">
                                @if ($appointment->status == 'pending')
                                    <span class="text-[9px] font-bold uppercase text-nafssiti-primary bg-nafssiti-primary/5 px-2 py-1 rounded border border-nafssiti-primary/10 italic">Attente Psychologue</span>
                                @else
                                    <span class="text-[9px] font-bold uppercase text-slate-400 italic">Traité</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-slate-400 italic">
                            Aucun rendez-vous trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
