@extends('layouts.psychologue')

@section('title', 'Gestion des Rendez-vous | NAFSSITI Pro')
@section('header_title', 'Demandes Entrantes')

@section('content')
    <div class="max-w-6xl mx-auto">
        {{-- Hero Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
            <div>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Nouvelles Demandes</h1>
                <p class="text-slate-400 text-xs mt-1 font-medium">Gérez vos demandes de consultations en attente.</p>
            </div>
        </div>



        {{-- Requests List as Table --}}
        <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Date & Heure</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Patient</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Note du patient</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-5">
                                <p class="text-xs font-bold text-slate-700">
                                    {{ \Carbon\Carbon::parse($appointment->appointmentDate)->translatedFormat('d F Y') }}</p>
                                <p class="text-[10px] text-slate-400 font-medium">
                                    {{ \Carbon\Carbon::parse($appointment->appointmentTime)->format('H:i') }} (45 min)</p>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $appointment->patient->user->avatar ? asset('storage/' . $appointment->patient->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($appointment->patient->user->name) . '&background=4dbfbf&color=fff' }}"
                                        class="w-7 h-7 rounded-sm object-cover">
                                    <div>
                                        <p class="text-xs font-bold text-slate-700">{{ $appointment->patient->user->name }}
                                        </p>
                                        <p class="text-[9px] text-amber-500 font-bold uppercase tracking-tighter">
                                            En attente</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-[10px] text-slate-600 italic lg:whitespace-normal lg:line-clamp-2 max-w-xs"
                                    title="{{ $appointment->notes }}">
                                    {{ $appointment->notes ?: 'Aucune remarque spécifiée.' }}
                                </p>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('psychologue.appointments.accept', $appointment) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="h-8 px-4 bg-nafssiti-primary text-white text-[9px] font-bold uppercase tracking-widest rounded-sm hover:bg-nafssiti-secondary transition-all shadow-sm hover:shadow-md flex items-center gap-1.5 border border-transparent">
                                            <i class="fas fa-check"></i> Accepter
                                        </button>
                                    </form>
                                    <button type="button" onclick="openRejectModal('{{ route('psychologue.appointments.refuse', $appointment) }}')"
                                            class="h-8 px-4 bg-white text-nafssiti-accent border border-nafssiti-accent/30 text-[9px] font-bold uppercase tracking-widest rounded-sm hover:bg-nafssiti-accent hover:text-white transition-all flex items-center gap-1.5 hover:shadow-md">
                                            <i class="fas fa-times"></i> Refuser
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5 text-slate-200">
                                    <i class="fas fa-inbox text-3xl"></i>
                                </div>
                                <h3 class="text-base font-bold text-slate-800">Boîte de réception vide</h3>
                                <p class="text-slate-400 text-xs mt-2 max-w-xs mx-auto">
                                    Vous n'avez aucune demande de rendez-vous en attente de validation.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-md shadow-xl w-full max-w-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest">Motif de Refus</h3>
                <button type="button" onclick="closeRejectModal()" class="text-slate-400 hover:text-red-500 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="p-6">
                    <p class="text-[11px] text-slate-500 mb-4">Ce message sera envoyé au patient pour expliquer le refus de son rendez-vous.</p>
                    <textarea name="rejection_reason" rows="5" class="w-full text-xs border-slate-200 rounded-sm focus:ring-nafssiti-accent focus:border-nafssiti-accent p-3" required>Bonjour,
Merci pour votre demande. Malheureusement, le créneau sélectionné n’est plus disponible ou ne peut pas être confirmé.
Nous vous invitons à choisir un autre horaire.
Nous vous remercions pour votre compréhension et restons à votre écoute.</textarea>
                </div>
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-slate-500 hover:text-slate-700 transition">Annuler</button>
                    <button type="submit" class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest bg-nafssiti-accent text-white rounded-sm hover:bg-red-600 transition shadow-sm">Confirmer le refus</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function openRejectModal(actionUrl) {
        document.getElementById('rejectForm').action = actionUrl;
        document.getElementById('rejectModal').classList.remove('hidden');
    }
    
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>
@endsection
