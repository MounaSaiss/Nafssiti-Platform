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
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 m-8 mb-0">
                    <p class="text-xs text-red-700 font-bold uppercase tracking-widest">{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('patient.storeReservation') }}" method="POST" class="p-8 space-y-12" id="reservation-form">
                @csrf
                <input type="hidden" name="availability_id" id="availability_id_input" required>
                <input type="hidden" name="appointment_time" id="appointment_time_input" required>
                
                <section>
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 bg-nafssiti-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-sm">1</span>
                            <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Sélectionner votre psychologue</h3>
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
                            <input type="radio" name="psychologist_id" value="{{ $psychologue->id }}" 
                                data-price="{{ $psychologue->pricePerSession }}"
                                class="peer sr-only psychologist-radio" {{ $loop->first ? 'checked' : '' }}>
                            <div class="p-3 border border-slate-100 rounded-sm bg-slate-50 peer-checked:bg-white peer-checked:border-nafssiti-primary peer-checked:ring-1 peer-checked:ring-nafssiti-primary transition-all flex items-center gap-3">
                                <img src="{{ $psychologue->photo ? asset('storage/' . $psychologue->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($psychologue->user->name) . '&background=4dbfbf&color=fff' }}" class="w-9 h-9 rounded-sm object-cover">
                                <div>
                                    <p class="text-[11px] font-bold text-slate-800">{{ $psychologue->user->name }}</p>
                                    <p class="text-[9px] text-slate-400 font-medium uppercase tracking-tighter">{{ $psychologue->specialization }}</p>
                                    <p class="text-[10px] text-nafssiti-primary font-bold mt-1">{{ $psychologue->pricePerSession }} DH <span class="text-[8px] text-slate-300 font-medium uppercase">/ séance</span></p>
                                </div>
                            </div>
                            <div class="absolute top-2 right-2 w-3 h-3 border border-slate-300 rounded-full peer-checked:bg-nafssiti-primary peer-checked:border-nafssiti-primary transition"></div>
                        </label>
                        @empty
                        <div class="col-span-3 py-10 text-center bg-slate-50 rounded-sm border border-slate-100">
                            <i class="fas fa-user-md text-slate-300 mb-2"></i>
                            <p class="text-[10px] text-slate-400 font-medium">Aucun psychologue disponible pour le moment.</p>
                        </div>
                        @endforelse
                        <div id="no-results" class="col-span-3 py-10 text-center bg-slate-50 rounded-sm border border-slate-100 hidden">
                            <i class="fas fa-search text-slate-300 mb-2"></i>
                            <p class="text-[10px] text-slate-400 font-medium">Aucun résultat trouvé pour votre recherche.</p>
                        </div>
                    </div>
                </section>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <section>
                        <div class="flex items-center gap-3 mb-6">
                            <span class="w-6 h-6 bg-nafssiti-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center">2</span>
                            <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Choisir la date</h3>
                        </div>
                        <input type="date" name="date" id="appointment_date" min="{{ date('Y-m-d') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <p id="date-hint" class="text-[10px] text-slate-400 mt-2 italic hidden">Aucune disponibilité pour ce psychologue actuellement.</p>
                    </section>

                    <section>
                        <div class="flex items-center gap-3 mb-6">
                            <span class="w-6 h-6 bg-nafssiti-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center">3</span>
                            <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Heures disponibles</h3>
                        </div>
                        <div id="available_times" class="grid grid-cols-4 gap-2">
                            <p class="col-span-4 text-[10px] text-slate-400 italic text-center py-4">Veuillez d'abord sélectionner une date.</p>
                        </div>
                    </section>
                </div>

                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-6 h-6 bg-nafssiti-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center">4</span>
                        <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Remarques (Optionnel)</h3>
                    </div>
                    <textarea name="notes" rows="3" 
                        class="w-full bg-slate-50 border border-slate-200 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition placeholder:italic"
                        placeholder="Ex: C'est ma première consultation, je souhaite discuter de..."></textarea>
                    <p class="text-[9px] text-slate-400 mt-2 italic">Vos remarques aideront le psychologue à mieux préparer la séance.</p>
                </section>


                <div class="pt-6 border-t border-slate-100 flex justify-end items-center gap-6">
                    <span class="text-[10px] text-slate-400 font-medium uppercase tracking-tighter italic">
                        Paiement à la séance : <span id="price-display">300</span> DH
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
    document.addEventListener('DOMContentLoaded', function() {
        const psychoRadios = document.querySelectorAll('.psychologist-radio');
        const dateInput = document.getElementById('appointment_date');
        const timesContainer = document.getElementById('available_times');
        const availabilityInput = document.getElementById('availability_id_input');
        const appointmentTimeInput = document.getElementById('appointment_time_input');
        const submitBtn = document.getElementById('submit-btn');
        const dateHint = document.getElementById('date-hint');
        const searchInput = document.getElementById('psy-search');
        const psychoCards = document.querySelectorAll('.psy-card');
        const priceDisplay = document.getElementById('price-display');

        // Search functionality
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

        function fetchAvailableDates(psychologistId) {
            dateInput.disabled = true;
            dateInput.value = '';
            dateHint.classList.add('hidden');
            clearTimes();

            fetch(`/patient/get-available-dates/${psychologistId}`)
                .then(response => response.json())
                .then(dates => {
                    if (dates.length > 0) {
                        dateInput.disabled = false;
                    } else {
                        dateHint.classList.remove('hidden');
                    }
                });
        }

        function fetchAvailableTimes(psychologistId, date) {
            timesContainer.innerHTML = '<div class="col-span-4 py-4 text-center"><i class="fas fa-spinner fa-spin text-nafssiti-primary"></i></div>';
            
            fetch(`/patient/get-available-times/${psychologistId}/${date}`)
                .then(response => response.json())
                .then(availabilities => {
                    timesContainer.innerHTML = '';
                    if (availabilities.length > 0) {
                        availabilities.forEach(avail => {
                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.className = 'time-slot-btn py-2.5 border border-slate-200 rounded-sm text-[10px] font-bold hover:border-nafssiti-primary transition';
                            
                            btn.innerText = avail.time;
                            btn.dataset.availabilityId = avail.availability_id;
                            btn.dataset.fullTime = avail.full_time;
                            
                            btn.addEventListener('click', function() {
                                document.querySelectorAll('.time-slot-btn').forEach(b => {
                                    b.classList.remove('bg-nafssiti-primary', 'text-white', 'border-nafssiti-primary');
                                    b.classList.add('border-slate-200');
                                });
                                this.classList.remove('border-slate-200');
                                this.classList.add('bg-nafssiti-primary', 'text-white', 'border-nafssiti-primary');
                                availabilityInput.value = this.dataset.availabilityId;
                                appointmentTimeInput.value = this.dataset.fullTime;
                                submitBtn.disabled = false;
                            });
                            
                            timesContainer.appendChild(btn);
                        });
                    } else {
                        timesContainer.innerHTML = '<p class="col-span-4 text-[10px] text-red-400 italic text-center py-4">Aucun créneau libre pour cette date.</p>';
                    }
                });
        }

        function clearTimes() {
            timesContainer.innerHTML = '<p class="col-span-4 text-[10px] text-slate-400 italic text-center py-4">Veuillez d\'abord sélectionner une date.</p>';
            availabilityInput.value = '';
            appointmentTimeInput.value = '';
            submitBtn.disabled = true;
        }

        psychoRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                fetchAvailableDates(this.value);
                // Update price display
                const selectedPrice = this.getAttribute('data-price');
                if (priceDisplay && selectedPrice) {
                    priceDisplay.innerText = selectedPrice;
                }
            });
        });

        dateInput.addEventListener('change', function() {
            const selectedPsy = document.querySelector('.psychologist-radio:checked');
            if (selectedPsy && this.value) {
                fetchAvailableTimes(selectedPsy.value, this.value);
            } else {
                clearTimes();
            }
        });

        // Initial load if a psychologist is already checked
        const checkedPsy = document.querySelector('.psychologist-radio:checked');
        if (checkedPsy) {
            fetchAvailableDates(checkedPsy.value);
            // Initial price display
            const initialPrice = checkedPsy.getAttribute('data-price');
            if (priceDisplay && initialPrice) {
                priceDisplay.innerText = initialPrice;
            }
        }
    });
</script>
@endsection