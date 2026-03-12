@extends('admin.layouts.app')

@section('title', 'Console Administration | NAFSSITI')

@section('page_title', 'Tableau de bord')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-5 border border-slate-200 shadow-sm rounded-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Utilisateurs actifs</p>
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">{{ $users->count() }}</h3>
                </div>
                <div class="p-2 bg-slate-50 rounded border border-slate-100 text-nafssiti-primary">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 border border-slate-200 shadow-sm rounded-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Psychologues</p>
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">{{ $psychologists->count() }}</h3>
                </div>
                <div class="p-2 bg-slate-50 rounded border border-slate-100 text-nafssiti-secondary">
                    <i class="fas fa-user-md"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 border border-slate-200 shadow-sm rounded-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Rendez-vous</p>
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">{{ $appointments->count() }}</h3>
                </div>
                <div class="p-2 bg-slate-50 rounded border border-slate-100 text-slate-800">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 border border-slate-200 shadow-sm rounded-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Revenu Global</p>
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">{{ number_format($globalRevenue, 2) }} <span
                            class="text-sm font-normal">DH</span>
                    </h3>
                </div>
                <div class="p-2 bg-slate-50 rounded border border-slate-100 text-nafssiti-primary">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 uppercase tracking-widest text-sm italic">Validation des nouveaux praticiens
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase tracking-tight">
                        <th class="px-6 py-4 font-bold border-b border-slate-200">ID</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200">Praticien</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200">Spécialité</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200 text-center">City</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200 text-right">Statut & Actions</th>
                    </tr>
                </thead>
                @foreach ($psychologists as $psychologist)
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="px-6 py-4 font-mono text-slate-400">{{ $psychologist->id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-800 uppercase">{{ $psychologist->user->name }}</span>
                                    <span
                                        class="text-slate-400 font-light tracking-tight text-[11px]">{{ $psychologist->user->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $psychologist->specialization }}</td>
                            <td class="px-6 py-4">{{ $psychologist->city }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-4">
                                    <!-- Badge de Statut -->
                                    <div>
                                        @if ($psychologist->validationStatus === 'approved')
                                            <span
                                                class="bg-green-100 text-green-800 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm border border-green-200 uppercase tracking-widest"><i
                                                    class="fas fa-check-circle mr-1"></i>Approuvé</span>
                                        @elseif($psychologist->validationStatus === 'rejected')
                                            <span
                                                class="bg-red-100 text-red-800 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm border border-red-200 uppercase tracking-widest"><i
                                                    class="fas fa-times-circle mr-1"></i>Refusé</span>
                                        @else
                                            <span
                                                class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm border border-amber-200 uppercase tracking-widest"><i
                                                    class="fas fa-hourglass-half mr-1"></i>En attente</span>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex justify-end gap-2 border-l border-slate-200 pl-4">
                                        @if ($psychologist->validationStatus !== 'approved')
                                            <a href="{{ route('admin.approvePsychologist', $psychologist->id) }}"
                                                class="flex items-center justify-center w-8 h-8 rounded-sm bg-slate-50 text-green-600 hover:bg-green-600 hover:text-white border border-slate-200 hover:border-green-600 shadow-sm transition-all"
                                                title="Approuver">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        @endif
                                        @if ($psychologist->validationStatus !== 'rejected')
                                            <a href="{{ route('admin.rejectPsychologist', $psychologist->id) }}"
                                                class="flex items-center justify-center w-8 h-8 rounded-sm bg-slate-50 text-red-500 hover:bg-red-600 hover:text-white border border-slate-200 hover:border-red-600 shadow-sm transition-all"
                                                title="Refuser">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
        </div>
    </div>
@endsection
