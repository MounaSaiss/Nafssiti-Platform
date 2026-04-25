@extends('layouts.psychologue')

@section('title', 'Dashboard | NAFSSITI')

@section('content')
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-3" aria-label="Statistiques">
        <article
            class="relative bg-white border border-slate-100 rounded-2xl p-6 overflow-hidden hover:shadow-md transition-shadow">
            <p class="text-[10px] font-semibold tracking-[.1em] uppercase text-slate-400 mb-3">Total Rendez-vous</p>
            <p class="text-2xl font-semibold text-slate-900 leading-none mb-1">{{ $totalAppointments }}</p>
            <p class="text-[11px] italic text-slate-400">Historique complet</p>
            <span class="absolute bottom-0 left-0 right-0 h-[3px] bg-teal-500 rounded-b-2xl"></span>
        </article>

        <article
            class="relative bg-white border border-slate-100 rounded-2xl p-6 overflow-hidden hover:shadow-md transition-shadow">
            <p class="text-[10px] font-semibold tracking-[.1em] uppercase text-slate-400 mb-3">Aujourd'hui</p>
            <p class="text-2xl font-semibold text-slate-900 leading-none mb-1">{{ $appointmentsToday }}</p>
            <p class="text-[11px] italic text-slate-400">Séances prévues aujourd'hui</p>
            <span
                class="absolute bottom-0 left-0 right-0 h-[3px] bg-gradient-to-r from-teal-400 to-cyan-400 rounded-b-2xl"></span>
        </article>

        <article
            class="relative bg-white border border-slate-100 rounded-2xl p-6 overflow-hidden hover:shadow-md transition-shadow">
            <p class="text-[10px] font-semibold tracking-[.1em] uppercase text-slate-400 mb-3">Séances Passées</p>
            <p class="text-2xl font-semibold text-slate-900 leading-none mb-1">{{ $pastAppointments }}</p>
            <p class="text-[11px] italic text-slate-400">Terminées ou déjà passées</p>
            <span class="absolute bottom-0 left-0 right-0 h-[3px] bg-slate-700 rounded-b-2xl"></span>
        </article>

    </section>

    {{-- Calendar --}}
    <section class="bg-white border border-slate-100 rounded-2xl p-8 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <span class="w-7 h-7 rounded-lg bg-teal-50 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </span>
                <h2 class="text-[11px] font-semibold tracking-[.1em] uppercase text-slate-500">
                    Mon Emploi du Temps Hebdomadaire
                </h2>
            </div>

            <div class="hidden sm:flex items-center gap-5">
                <span class="flex items-center gap-1.5 text-[9px] font-semibold tracking-[.08em] uppercase text-slate-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span> Confirmé
                </span>
                <span class="flex items-center gap-1.5 text-[9px] font-semibold tracking-[.08em] uppercase text-slate-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> En attente
                </span>
                <span class="flex items-center gap-1.5 text-[9px] font-semibold tracking-[.08em] uppercase text-slate-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-700"></span> Indisponible
                </span>
            </div>
        </div>

        {{-- FullCalendar --}}
        <div id="calendar" class="min-h-[600px]"></div>

    </section>

    <div id="bookingModal" class="fixed inset-0 z-[60] hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-10">

            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal()"></div>

            <div class="relative w-full max-w-md bg-white rounded-2xl border border-slate-200 shadow-2xl overflow-hidden">

                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/60">
                    <span
                        class="text-[9px] font-semibold tracking-[.12em] uppercase bg-teal-50 text-teal-700 px-3 py-1 rounded-full">
                        Programmation Rapide
                    </span>
                    <button onclick="closeModal()"
                        class="w-7 h-7 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 text-sm transition">
                        ✕
                    </button>
                </div>

                <form id="quickEventForm" class="px-6 py-5 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-[10px] font-semibold tracking-[.09em] uppercase text-slate-400 mb-1.5">
                            Type d'événement
                        </label>
                        <select name="type" id="event_type" onchange="togglePatientSelect()"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-400 transition">
                            <option value="appointment">Rendez-vous Patient</option>
                            <option value="unavailability">Indisponibilité (Blocage)</option>
                        </select>
                    </div>

                    <div id="patient_select_group">
                        <label
                            class="block text-[10px] font-semibold tracking-[.09em] uppercase text-slate-400 mb-1.5">Patient</label>
                        <select name="patient_id"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-400 transition">
                            <option value="">Sélectionner un patient suivi...</option>
                            @foreach ($followedPatients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label
                                class="block text-[10px] font-semibold tracking-[.09em] uppercase text-slate-400 mb-1.5">Date</label>
                            <input type="date" name="date" id="event_date" readonly
                                class="w-full bg-slate-100 border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-500 outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-semibold tracking-[.09em] uppercase text-slate-400 mb-1.5">Heure
                                Début</label>
                            <input type="time" name="start_time" id="event_start"
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-teal-400 transition">
                        </div>
                    </div>

                    <div id="end_time_group" class="hidden">
                        <label
                            class="block text-[10px] font-semibold tracking-[.09em] uppercase text-slate-400 mb-1.5">Heure
                            Fin</label>
                        <input type="time" name="end_time" id="event_end"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-teal-400 transition">
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold tracking-[.09em] uppercase text-slate-400 mb-1.5">
                            Notes (Optionnel)
                        </label>
                        <textarea name="notes" rows="2"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-teal-400 transition resize-none"
                            placeholder="Précisions sur la séance..."></textarea>
                    </div>
                </form>

                <div class="flex gap-2.5 px-6 py-4 border-t border-slate-100 bg-slate-50/60">
                    <button type="button" onclick="closeModal()"
                        class="flex-1 py-2.5 border border-slate-200 bg-white text-slate-500 rounded-lg text-[10px] font-semibold tracking-[.09em] uppercase hover:bg-slate-100 transition">
                        Annuler
                    </button>
                    <button type="submit" form="quickEventForm"
                        class="flex-1 py-2.5 bg-teal-500 hover:bg-teal-600 text-white rounded-lg text-[10px] font-semibold tracking-[.09em] uppercase transition shadow-sm shadow-teal-200">
                        Confirmer
                    </button>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core/locales/fr.global.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let calendarEl = document.getElementById('calendar');
                if (!calendarEl) return;

                let calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'fr',
                    selectable: true,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    slotMinTime: '09:00:00',
                    slotMaxTime: '19:00:00',
                    allDaySlot: false,
                    height: 'auto',
                    nowIndicator: true,
                    events: "{{ route('psychologue.calendar.events') }}",

                    select: function(info) {
                        // console.log(info);  
                        const dateStr = info.startStr.split('T')[0] ?? info.startStr;
                        const startTime = info.startStr.split('T')[1]?.substring(0, 5) ?? '09:00';
                        const endTime = info.endStr.split('T')[1]?.substring(0, 5) ?? '10:00';

                        document.getElementById('event_date').value = dateStr;
                        document.getElementById('event_start').value = startTime;
                        document.getElementById('event_end').value = endTime;
                        document.getElementById('bookingModal').classList.remove('hidden');
                    },

                    eventDidMount: function(info) {
                        // console.log(info);
                        if (info.event.extendedProps.type === 'appointment') {
                            info.el.title = "Patient: " + info.event.extendedProps.patient;
                        }
                    }
                });

                calendar.render();

                document.getElementById('quickEventForm').onsubmit = function(e) {
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
                            if (!response.ok) throw new Error(data.message || 'Erreur serveur');
                            return data;
                        })
                        .then(data => {
                            if (data.status === 'success') {
                                closeModal();
                                calendar.refetchEvents();
                            }
                        })
                        .catch(error => alert('Erreur: ' + error.message));

                    return false;
                };
            });

            function closeModal() {
                document.getElementById('bookingModal').classList.add('hidden');
                document.getElementById('quickEventForm').reset();
            }

            function togglePatientSelect() {
                const type = document.getElementById('event_type').value;
                document.getElementById('patient_select_group').classList.toggle('hidden', type !== 'appointment');
                document.getElementById('end_time_group').classList.toggle('hidden', type !== 'unavailability');
            }
        </script>
    @endpush

@endsection

@section('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* ── Base ─────────────────────────────────────────────────────── */
        #calendar {
            font-family: 'DM Sans', sans-serif;
        }

        /* ── Toolbar ──────────────────────────────────────────────────── */
        .fc .fc-toolbar {
            gap: .75rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .fc .fc-toolbar-title {
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
            letter-spacing: -.01em;
        }

        /* Boutons prev / next / today */
        .fc .fc-button {
            font-family: 'DM Sans', sans-serif;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            color: #475569;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: .35rem .75rem;
            transition: all .15s;
            box-shadow: none;
        }

        .fc .fc-button:hover {
            background: #f0fdfa;
            border-color: #99f6e4;
            color: #0f766e;
            box-shadow: none;
        }

        .fc .fc-button:focus {
            box-shadow: 0 0 0 3px rgba(13, 148, 136, .15);
            outline: none;
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active,
        .fc .fc-button-primary:not(:disabled):active {
            background: #f0fdfa;
            border-color: #99f6e4;
            color: #0f766e;
            box-shadow: none;
        }

        .fc .fc-button .fc-icon {
            font-size: 14px;
            vertical-align: middle;
        }

        /* Groupe de vues (Mois / Semaine / Jour) */
        .fc .fc-button-group {
            background: #f1f5f9;
            padding: 3px;
            border-radius: 8px;
            gap: 2px;
            border: 1px solid #e2e8f0;
        }

        .fc .fc-button-group .fc-button {
            background: transparent;
            border: none;
            border-radius: 6px;
            color: #64748b;
            font-size: 11px;
            font-weight: 500;
            padding: .3rem .8rem;
        }

        .fc .fc-button-group .fc-button:hover {
            background: rgba(255, 255, 255, .7);
            color: #1e293b;
        }

        .fc .fc-button-group .fc-button-active {
            background: #ffffff !important;
            color: #0f766e !important;
            font-weight: 600 !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08) !important;
        }

        /* ── Grille ───────────────────────────────────────────────────── */
        .fc .fc-scrollgrid {
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #e2e8f0 !important;
        }

        .fc .fc-scrollgrid-section>td,
        .fc .fc-scrollgrid-section>th {
            border: none;
        }

        .fc-theme-standard td,
        .fc-theme-standard th {
            border-color: #f1f5f9;
        }

        .fc-theme-standard .fc-scrollgrid {
            border-color: #e2e8f0;
        }

        /* En-têtes de jours */
        .fc .fc-col-header-cell {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: .6rem 0;
        }

        .fc .fc-col-header-cell-cushion {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .09em;
            text-transform: uppercase;
            color: #94a3b8;
            text-decoration: none;
        }

        /* Jours weekend */
        .fc .fc-day-sat .fc-col-header-cell-cushion,
        .fc .fc-day-sun .fc-col-header-cell-cushion {
            color: #cbd5e1;
        }

        .fc .fc-day-sat,
        .fc .fc-day-sun {
            background: #fafbfc;
        }

        /* Cellules de jours */
        .fc .fc-daygrid-day {
            transition: background .12s;
        }

        .fc .fc-daygrid-day:hover {
            background: #fafbfc;
            cursor: pointer;
        }

        /* Numéro du jour */
        .fc .fc-daygrid-day-number {
            font-size: 12px;
            font-weight: 500;
            color: #334155;
            padding: .5rem .6rem .2rem;
            text-decoration: none;
            transition: color .12s;
        }

        .fc .fc-daygrid-day-number:hover {
            color: #0d9488;
        }

        .fc .fc-day-other .fc-daygrid-day-number {
            color: #cbd5e1;
        }

        /* Aujourd'hui */
        .fc .fc-day-today {
            background: #f0fdfa !important;
        }

        .fc .fc-day-today .fc-daygrid-day-number {
            background: #0d9488;
            color: #ffffff;
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: .4rem .4rem .2rem;
            font-weight: 600;
            padding: 0;
        }

        /* Indicateur d'heure courante */
        .fc .fc-timegrid-now-indicator-line {
            border-color: #0d9488;
            border-width: 2px;
        }

        .fc .fc-timegrid-now-indicator-arrow {
            border-top-color: #0d9488;
            border-bottom-color: #0d9488;
        }

        /* ── Événements ───────────────────────────────────────────────── */
        .fc .fc-event {
            border: none;
            border-radius: 5px;
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            font-weight: 500;
            padding: 2px 6px;
            transition: filter .12s, transform .1s;
            cursor: pointer;
        }

        .fc .fc-event:hover {
            filter: brightness(.93);
            transform: translateY(-1px);
        }

        .fc .fc-event-title {
            font-weight: 500;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .fc .fc-event-time {
            font-weight: 600;
            opacity: .75;
            margin-right: 3px;
        }

        .fc .fc-daygrid-event {
            border-radius: 4px;
            margin-bottom: 2px;
        }

        /* Type : rendez-vous confirmé */
        .fc .fc-event.type-appointment {
            background: #f0fdfa;
            color: #0f766e;
            border-left: 3px solid #0d9488;
        }

        /* Type : en attente */
        .fc .fc-event.type-pending {
            background: #fff1f2;
            color: #be123c;
            border-left: 3px solid #f43f5e;
        }

        /* Type : indisponibilité */
        .fc .fc-event.type-unavailability {
            background: #f1f5f9;
            color: #475569;
            border-left: 3px solid #94a3b8;
        }

        /* Bouton "plus" (+N) */
        .fc .fc-daygrid-more-link {
            font-size: 10px;
            font-weight: 600;
            color: #64748b;
            background: #f1f5f9;
            border-radius: 4px;
            padding: 1px 5px;
            transition: all .12s;
        }

        .fc .fc-daygrid-more-link:hover {
            background: #e2e8f0;
            color: #334155;
        }

        /* ── Vue Semaine / Jour ───────────────────────────────────────── */
        .fc .fc-timegrid-slot {
            height: 48px;
            border-color: #f1f5f9;
        }

        .fc .fc-timegrid-slot-label-cushion {
            font-size: 10px;
            font-weight: 500;
            color: #94a3b8;
            letter-spacing: .03em;
        }

        .fc .fc-timegrid-axis {
            width: 52px;
        }

        .fc .fc-timegrid-event {
            border-radius: 6px;
            padding: 4px 8px;
            border: none;
        }

        .fc .fc-timegrid-event .fc-event-title {
            font-size: 12px;
        }

        .fc .fc-timegrid-event .fc-event-time {
            font-size: 10px;
        }

        /* Fond des colonnes weekend en vue semaine */
        .fc .fc-timegrid .fc-day-sat,
        .fc .fc-timegrid .fc-day-sun {
            background: #fafbfc;
        }

        /* ── Popover (vue "more") ─────────────────────────────────────── */
        .fc .fc-popover {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .1);
            overflow: hidden;
        }

        .fc .fc-popover-header {
            background: #f8fafc;
            padding: .5rem .75rem;
            font-size: 11px;
            font-weight: 600;
            color: #475569;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .fc .fc-popover-body {
            padding: .5rem .6rem;
        }

        /* ── Responsive mobile ────────────────────────────────────────── */
        @media (max-width: 640px) {
            .fc .fc-toolbar {
                flex-direction: column;
                align-items: flex-start;
                gap: .6rem;
            }

            .fc .fc-toolbar-title {
                font-size: 14px;
            }

            .fc .fc-button-group .fc-button {
                padding: .3rem .55rem;
                font-size: 10px;
            }

            .fc .fc-daygrid-day-number {
                font-size: 11px;
            }

            .fc .fc-event-title {
                font-size: 10px;
            }

            .fc .fc-timegrid-slot {
                height: 36px;
            }

            .fc .fc-col-header-cell-cushion {
                font-size: 9px;
                letter-spacing: .05em;
            }
        }
    </style>
@endsection
