@extends('layouts.psychologue')

@section('title', 'Dashboard Psychologue | NAFSSITI')

@section('content')
    <div class="space-y-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in" style="animation-delay: 0.1s;">
            <div class="bg-white p-6 border-b-4 border-nafssiti-primary rounded-sm shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Rendez-vous</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-2">{{ $totalAppointments }}</h3>
                <p class="text-[10px] text-nafssiti-secondary font-bold mt-1">Historique complet</p>
            </div>
            <div class="bg-white p-6 border-b-4 border-nafssiti-secondary rounded-sm shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Aujourd'hui</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-2">{{ $appointmentsToday }}</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-1 italic">Séances prévues aujourd'hui</p>
            </div>
            <div class="bg-white p-6 border-b-4 border-nafssiti-dark rounded-sm shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Séances Passées</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-2">{{ $pastAppointments }}</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-1 italic">Terminées ou déjà passées</p>
            </div>
        </div>

        {{-- Nouveau calendrier --}}
        <div class="bg-white p-8 border border-slate-200 rounded-sm shadow-sm animate-fade-in"
            style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-nafssiti-primary"></i> Mon Emploi du Temps Hebdomadaire
                </h3>
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1.5 text-[9px] font-bold text-slate-400 uppercase">
                        <span class="w-2 h-2 rounded-full bg-nafssiti-primary"></span> Confirmé
                    </span>
                    <span class="flex items-center gap-1.5 text-[9px] font-bold text-slate-400 uppercase">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span> En attente
                    </span>
                    <span class="flex items-center gap-1.5 text-[9px] font-bold text-slate-400 uppercase">
                        <span class="w-2 h-2 rounded-full bg-slate-800"></span> Indisponible
                    </span>
                </div>
            </div>

            <div id="calendar" class="min-h-[650px]"></div>
        </div>

        {{-- Modale de réservation rapide --}}
        <div id="bookingModal" class="fixed inset-0 z-[60] hidden overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-slate-900 bg-opacity-50 backdrop-blur-sm"
                    onclick="closeModal()"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div
                    class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-sm shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200">
                    <div class="px-8 py-6 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600">
                            <i class="fas fa-plus-circle text-nafssiti-primary mr-2"></i> Programmation Rapide
                        </h3>
                        <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="quickEventForm" class="p-8 space-y-6">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Type
                                d'événement</label>
                            <select name="type" id="event_type" onchange="togglePatientSelect()"
                                class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                                <option value="appointment">Rendez-vous Patient</option>
                                <option value="unavailability">Indisponibilité (Blocage)</option>
                            </select>
                        </div>

                        <div id="patient_select_group">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Patient</label>
                            <select name="patient_id"
                                class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                                <option value="">Sélectionner un patient suivi...</option>
                                @foreach ($followedPatients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Date</label>
                                <input type="date" name="date" id="event_date" readonly
                                    class="w-full bg-slate-100 border border-slate-100 rounded-sm px-4 py-3 text-xs text-slate-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Heure Début</label>
                                <input type="time" name="start_time" id="event_start"
                                    class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                            </div>
                        </div>

                        <div id="end_time_group" class="hidden">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Heure Fin</label>
                            <input type="time" name="end_time" id="event_end"
                                class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Notes
                                (Optionnel)</label>
                            <textarea name="notes" rows="2"
                                class="w-full bg-slate-50 border border-slate-100 rounded-sm px-4 py-3 text-xs outline-none focus:border-nafssiti-primary transition"
                                placeholder="Précisions sur la séance..."></textarea>
                        </div>

                        <div class="pt-4 flex gap-3">
                            <button type="button" onclick="closeModal()"
                                class="flex-1 py-3 border border-slate-200 text-slate-600 rounded-sm text-[10px] font-bold uppercase tracking-widest hover:bg-slate-50 transition">
                                Annuler
                            </button>
                            <button type="submit"
                                class="flex-1 py-3 bg-nafssiti-primary text-white rounded-sm text-[10px] font-bold uppercase tracking-widest hover:bg-teal-600 transition shadow-md">
                                Confirmer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                if (!calendarEl) return;

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridWeek',
                    locale: 'fr',
                    selectable: true,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    slotMinTime: '08:00:00',
                    slotMaxTime: '20:00:00',
                    allDaySlot: false,
                    height: 'auto',
                    nowIndicator: true,
                    events: "{{ route('psychologue.calendar.events') }}",

                    select: function(info) {
                        const dateStr = info.startStr.split('T')[0];
                        const startTime = info.startStr.split('T')[1].substring(0, 5);
                        const endTime = info.endStr.split('T')[1].substring(0, 5);

                        document.getElementById('event_date').value = dateStr;
                        document.getElementById('event_start').value = startTime;
                        document.getElementById('event_end').value = endTime;

                        document.getElementById('bookingModal').classList.remove('hidden');
                    },

                    eventDidMount: function(info) {
                        if (info.event.extendedProps.type === 'appointment') {
                            info.el.title = "Patient: " + info.event.extendedProps.patient;
                        }
                    }
                });
                calendar.render();

                window.submitQuickEvent = function(e) {
                    e.preventDefault();
                    const form = document.getElementById('quickEventForm');
                    const formData = new FormData(form);

                    fetch("{{ route('psychologue.calendar.quickStore') }}", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Accept': 'application/json'
                            }
                        })
                        .then(async response => {
                            const data = await response.json();
                            if (!response.ok) {
                                throw new Error(data.message || 'Erreur serveur');
                            }
                            return data;
                        })
                        .then(data => {
                            if (data.status === 'success') {
                                closeModal();
                                calendar.refetchEvents();
                                alert(data.message);
                            } else {
                                alert('Erreur: ' + (data.message || 'Inconnue'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Erreur: ' + error.message);
                        });
                    return false;
                };

                document.getElementById('quickEventForm').onsubmit = window.submitQuickEvent;
            });

            function closeModal() {
                document.getElementById('bookingModal').classList.add('hidden');
                document.getElementById('quickEventForm').reset();
            }

            function togglePatientSelect() {
                const type = document.getElementById('event_type').value;
                const patientGroup = document.getElementById('patient_select_group');
                const endTimeGroup = document.getElementById('end_time_group');

                if (type === 'appointment') {
                    patientGroup.classList.remove('hidden');
                    endTimeGroup.classList.add('hidden');
                } else {
                    patientGroup.classList.add('hidden');
                    endTimeGroup.classList.remove('hidden');
                }
            }
        </script>
    @endpush
@endsection
