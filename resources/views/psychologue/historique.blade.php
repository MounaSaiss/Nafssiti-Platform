@extends('layouts.psychologue')

@section('title', 'Historique des Séances | NAFSSITI Pro')
@section('header_title', 'Archive des Consultations')

@section('styles')
    <style>
        .timeline-line::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: repeating-linear-gradient(to bottom, #e2e8f0 0%, #e2e8f0 50%, transparent 50%, transparent 100%);
            background-size: 1px 10px;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto">
        @forelse($appointments as $monthYear => $monthAppointments)
        <div class="mb-12">
            <div class="flex items-center gap-4 mb-8">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-tighter">{{ $monthYear }}</h3>
                <div class="h-[1px] flex-1 bg-slate-200"></div>
            </div>

            <div class="relative timeline-line ml-4 space-y-8">
                @foreach($monthAppointments as $appointment)
                <div class="relative pl-12 group">
                    <div class="absolute left-0 top-1 w-10 h-10 bg-white border-2 {{ $appointment->status === 'completed' ? 'border-nafssiti-primary' : 'border-slate-200' }} rounded-sm flex items-center justify-center z-10 shadow-sm group-hover:scale-110 transition">
                        <span class="text-[10px] font-bold {{ $appointment->status === 'completed' ? 'text-nafssiti-primary' : 'text-slate-400' }} uppercase">
                            {{ \Carbon\Carbon::parse($appointment->appointmentDate)->format('d') }}
                        </span>
                    </div>

                    <div class="bg-white p-6 border border-slate-200 rounded-sm shadow-sm hover:border-nafssiti-secondary transition flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <img src="{{ $appointment->patient->photo ? asset('storage/' . $appointment->patient->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($appointment->patient->user->name) . '&background=f1f5f9&color=4dbfbf' }}" class="w-12 h-12 rounded-sm grayscale group-hover:grayscale-0 transition">
                            <div>
                                <p class="text-xs font-bold text-slate-800">{{ $appointment->patient->user->name }}</p>
                                <p class="text-[10px] text-slate-400 font-medium">Séance à {{ \Carbon\Carbon::parse($appointment->appointmentTime)->format('H:i') }}</p>
                                @if($appointment->notes)
                                <p class="text-[9px] text-slate-400 mt-2 italic border-l-2 border-slate-100 pl-2 leading-relaxed max-w-sm">
                                    <i class="fas fa-sticky-note mr-1 text-slate-200"></i> {{ $appointment->notes }}
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-10">
                            <div class="text-center">
                                <p class="text-[9px] font-bold text-slate-300 uppercase tracking-widest">Durée</p>
                                <p class="text-xs font-bold text-slate-600">60 min</p>
                            </div>
                            <div class="px-4 py-1.5 bg-slate-50 border border-slate-100 rounded-sm">
                                <span class="text-[9px] font-bold text-nafssiti-secondary uppercase tracking-tighter">
                                    <i class="fas fa-check-circle mr-1"></i> Terminée
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="py-20 text-center">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-history text-slate-200 text-2xl"></i>
            </div>
            <p class="text-slate-400 italic text-sm">Aucun historique de séance disponible pour le moment.</p>
        </div>
        @endforelse
    </div>
@endsection
