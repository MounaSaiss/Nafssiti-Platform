@extends('layouts.psychologue')

@section('title', 'Demandes de Suivi | NAFSSITI Pro')
@section('header_title', 'Demandes de Suivi')

@section('content')

@if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-sm flex items-center gap-3">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

<div class="mb-6">
    <h1 class="text-[18px] font-bold text-slate-900 tracking-tight">Demandes de suivi reçues</h1>
    <p class="text-[11px] text-slate-500 mt-1">Gérez ici les patients qui souhaitent entamer un suivi régulier avec vous.</p>
</div>

<div class="bg-white rounded-sm shadow-sm border border-slate-200 overflow-hidden">
    <table class="w-full text-[11px]">
        <thead>
            <tr class="border-b border-slate-100 bg-slate-50">
                <th class="text-left px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Patient</th>
                <th class="text-left px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Date de demande</th>
                <th class="text-left px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Statut</th>
                <th class="text-right px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($requests as $req)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $req->patient->user->avatar ? asset('storage/' . $req->patient->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($req->patient->user->name ?? 'P') . '&background=f1f5f9&color=4dbfbf' }}"
                                 class="w-10 h-10 rounded-sm object-cover border border-slate-100">
                            <div>
                                <p class="font-bold text-slate-800">{{ $req->patient->user->name ?? 'Patient' }}</p>
                                <p class="text-[10px] text-slate-400">{{ $req->patient->user->email ?? '' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">
                        {{ $req->created_at->translatedFormat('d M Y à H:i') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($req->status === 'pending')
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-1 bg-yellow-50 text-yellow-600 border border-yellow-200 rounded-sm uppercase tracking-wider">
                                <i class="fas fa-hourglass-half"></i> En attente
                            </span>
                        @elseif($req->status === 'accepted')
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-1 bg-green-50 text-green-600 border border-green-200 rounded-sm uppercase tracking-wider">
                                <i class="fas fa-check"></i> Accepté
                            </span>
                        @elseif($req->status === 'rejected')
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-1 bg-red-50 text-red-500 border border-red-200 rounded-sm uppercase tracking-wider">
                                <i class="fas fa-times"></i> Refusé
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($req->status === 'pending')
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('psychologue.follow_requests.accept', $req) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 bg-nafssiti-primary hover:bg-teal-500 text-white rounded-sm transition">
                                        <i class="fas fa-check"></i> Accepter
                                    </button>
                                </form>
                                <form action="{{ route('psychologue.follow_requests.reject', $req) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 border border-slate-200 text-slate-600 hover:bg-red-50 hover:text-red-500 hover:border-red-200 rounded-sm transition">
                                        <i class="fas fa-times"></i> Refuser
                                    </button>
                                </form>
                            </div>
                        @elseif($req->status === 'accepted')
                            <div class="flex justify-end">
                                <a href="{{ route('psychologue.shared_room.index', $req->patient_id) }}" class="flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 bg-nafssiti-secondary hover:bg-green-500 text-white rounded-sm transition">
                                    <i class="fas fa-folder-open"></i> Accéder au dossier
                                </a>
                            </div>
                        @else
                            <p class="text-[11px] text-slate-400 text-right italic">Traité</p>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                        <i class="fas fa-inbox text-3xl mb-3"></i>
                        <p class="text-[11px] font-medium">Aucune demande de suivi reçue pour le moment.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
