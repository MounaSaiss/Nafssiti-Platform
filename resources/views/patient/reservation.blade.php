@extends('layouts.patient')

@section('title', 'Réserver une Séance | NAFSSITI')
@section('header_title', 'Formulaire de Réservation')

@section('styles')
    <style>
        .psy-list::-webkit-scrollbar {
            width: 4px;
        }

        .psy-list::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .psy-list::-webkit-scrollbar-thumb {
            background: #4dbfbf;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-5xl">
        <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 m-8 mb-0">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li class="text-xs text-red-700 font-bold uppercase tracking-widest">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('patient.payment') }}" method="POST" class="p-8 space-y-12" id="reservation-form">
                @csrf
                {{-- Hidden inputs for final submission --}}
                <input type="hidden" name="psychologist_id" value="{{ $selectedPsychologistId }}">
                <input type="hidden" name="appointment_date" value="{{ $selectedDate }}">
                <input type="hidden" name="appointment_time" id="appointment_time_input"
                    value="{{ old('appointment_time') }}">

                {{-- Step 1: Psychologist --}}
                <section>
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                        <div class="flex items-center gap-3">
                            <span
                                class="w-6 h-6 bg-nafssiti-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-sm">1</span>
                            <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Sélectionner votre
                                psychologue</h3>
                        </div>
                        <div class="relative w-full md:w-72">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                            <input type="text" id="psy-search" placeholder="Rechercher par nom..."
                                class="w-full bg-slate-50 border border-slate-100 rounded-sm py-2.5 pl-9 pr-4 text-[11px] outline-none focus:border-nafssiti-primary transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 max-h-64 overflow-y-auto pr-2 psy-list">
                        @forelse($psychologues as $psychologue)
                            <label class="relative cursor-pointer group psy-card"
                                data-search="{{ strtolower($psychologue->user->name) }} {{ strtolower($psychologue->specialization) }}">
                                <input type="radio" value="{{ $psychologue->id }}"
                                    class="peer sr-only psychologist-radio"
                                    onchange="updateURL('psychologist_id', this.value)"
                                    {{ $selectedPsychologistId == $psychologue->id ? 'checked' : '' }}>
                                <div
                                    class="p-3 border border-slate-100 rounded-sm bg-slate-50 peer-checked:bg-white peer-checked:border-nafssiti-primary peer-checked:ring-1 peer-checked:ring-nafssiti-primary transition-all flex items-center gap-3">
                                    <img src="{{ $psychologue->user->avatar ? asset('storage/' . $psychologue->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($psychologue->user->name) . '&background=4dbfbf&color=fff' }}"
                                        class="w-9 h-9 rounded-sm object-cover">
                                    <div>
                                        <p class="text-[11px] font-bold text-slate-800">{{ $psychologue->user->name }}</p>
                                        <p class="text-[9px] text-slate-400 font-medium uppercase tracking-tighter">
                                            {{ $psychologue->specialization }}</p>
                                        <p class="text-[10px] text-nafssiti-primary font-bold mt-1">
                                            {{ $psychologue->pricePerSession }} DH <span
                                                class="text-[8px] text-slate-300 font-medium uppercase">/ séance</span></p>
                                    </div>
                                </div>
                                <div
                                    class="absolute top-2 right-2 w-3 h-3 border border-slate-300 rounded-full peer-checked:bg-nafssiti-primary peer-checked:border-nafssiti-primary transition">
                                </div>
                            </label>
                        @empty
                            <div class="col-span-3 py-10 text-center bg-slate-50 rounded-sm border border-slate-100">
                                <i class="fas fa-user-md text-slate-300 mb-2"></i>
                                <p class="text-[10px] text-slate-400 font-medium">Aucun psychologue disponible pour le
                                    moment.</p>
                            </div>
                        @endforelse
                        <div id="no-results"
                            class="col-span-3 py-10 text-center bg-slate-50 rounded-sm border border-slate-100 hidden">
                            <i class="fas fa-search text-slate-300 mb-2"></i>
                            <p class="text-[10px] text-slate-400 font-medium">Aucun résultat trouvé pour votre recherche.
                            </p>
                        </div>
                    </div>
                </section>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    {{-- Step 2: Date --}}
                    <section>
                        <div class="flex items-center gap-3 mb-6">
                            <span
                                class="w-6 h-6 bg-nafssiti-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center">2</span>
                            <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Choisir la date</h3>
                        </div>

                        @if ($selectedPsychologistId)
                            <input type="date" id="appointment_date" min="{{ date('Y-m-d') }}"
                                value="{{ $selectedDate }}" onchange="updateURL('appointment_date', this.value)"
                                class="w-full bg-slate-50 border border-slate-200 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                        @else
                            <p
                                class="text-[10px] text-slate-400 italic py-4 border border-dashed border-slate-200 rounded-sm text-center">
                                Veuillez d'abord sélectionner un psychologue.
                            </p>
                        @endif
                    </section>

                    {{-- Step 3: Time --}}
                    <section>
                        <div class="flex items-center gap-3 mb-6">
                            <span
                                class="w-6 h-6 bg-nafssiti-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center">3</span>
                            <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Heures disponibles
                            </h3>
                        </div>

                        <div id="available_times" class="grid grid-cols-4 gap-2">
                            @if ($selectedDate)
                                @forelse($availableFree as $slot)
                                    <button type="button" onclick="selectSlot(this, '{{ $slot['full_time'] }}')"
                                        class="time-slot-btn py-2.5 border border-slate-200 rounded-sm text-[10px] font-bold hover:border-nafssiti-primary transition {{ old('appointment_time') == $slot['full_time'] ? 'bg-nafssiti-primary text-white border-nafssiti-primary' : '' }}">
                                        {{ $slot['time'] }}
                                    </button>
                                @empty
                                    <p class="col-span-4 text-[10px] text-red-400 italic text-center py-4">Aucun créneau
                                        libre pour cette date.</p>
                                @endforelse
                            @else
                                <p
                                    class="col-span-4 text-[10px] text-slate-400 italic text-center py-4 border border-dashed border-slate-200 rounded-sm">
                                    Veuillez d'abord sélectionner une date.
                                </p>
                            @endif
                        </div>
                    </section>
                </div>

                {{-- Step 4: Notes --}}
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <span
                            class="w-6 h-6 bg-nafssiti-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center">4</span>
                        <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Remarques (Optionnel)
                        </h3>
                    </div>
                    <textarea name="notes" rows="3"
                        class="w-full bg-slate-50 border border-slate-200 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition placeholder:italic"
                        placeholder="Ex: C'est ma première consultation, je souhaite discuter de...">{{ old('notes') }}</textarea>
                    <p class="text-[9px] text-slate-400 mt-2 italic">Vos remarques aideront le psychologue à mieux préparer
                        la séance.</p>
                </section>


                <div class="pt-6 border-t border-slate-100 flex justify-end items-center gap-6">
                    @php
                        $selectedPsy = $psychologues->firstWhere('id', $selectedPsychologistId);
                    @endphp
                    <span class="text-[10px] text-slate-400 font-medium uppercase tracking-tighter italic">
                        Paiement à la séance : <span
                            id="price-display">{{ $selectedPsy ? $selectedPsy->pricePerSession : '---' }}</span> DH
                    </span>
                    <button type="submit" id="submit-btn" disabled
                        class="px-12 py-4 bg-nafssiti-dark text-white rounded-sm text-[10px] font-bold uppercase tracking-widest hover:bg-nafssiti-secondary transition shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
                        Confirmer la réservation
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function updateURL(param, value) {
            const url = new URL(window.location.href);
            url.searchParams.set(param, value);
            if (param === 'psychologist_id') {
                url.searchParams.delete('appointment_date'); // Reset date if psychologist changes
            }
            window.location.href = url.href;
        }

        function selectSlot(btn, fullTime) {
            // Clear previous selections
            document.querySelectorAll('.time-slot-btn').forEach(b => {
                b.classList.remove('bg-nafssiti-primary', 'text-white', 'border-nafssiti-primary');
                b.classList.add('border-slate-200');
            });

            // Mark current button as selected
            btn.classList.remove('border-slate-200');
            btn.classList.add('bg-nafssiti-primary', 'text-white', 'border-nafssiti-primary');

            // Set hidden inputs
            document.getElementById('appointment_time_input').value = fullTime;

            // Enable submit button
            document.getElementById('submit-btn').disabled = false;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('psy-search');
            const psychoCards = document.querySelectorAll('.psy-card');

            // Search functionality (pure client-side UI filter)
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.toLowerCase();
                    let hasResults = false;

                    psychoCards.forEach(card => {
                        const searchText = card.getAttribute('data-search');
                        if (searchText.includes(query)) {
                            card.style.display = 'block';
                            hasResults = true;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    const noResults = document.getElementById('no-results');
                    if (hasResults || psychoCards.length === 0) {
                        noResults.classList.add('hidden');
                    } else {
                        noResults.classList.remove('hidden');
                    }
                });
            }

            // Keep submit button enabled if we have values (e.g. after validation error)
            if (document.getElementById('appointment_time_input').value) {
                document.getElementById('submit-btn').disabled = false;
            }
        });
    </script>
@endsection
