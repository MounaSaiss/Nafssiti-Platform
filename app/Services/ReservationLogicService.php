<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Unavailability;
use Carbon\Carbon;

class ReservationLogicService
{
    // Calcule les créneaux horaires disponibles d'une heure pour un psychologue.
    public function getAvailableSlots($psychologistId, $date)
    {
        $carbonDate = Carbon::parse($date);
        $dayOfWeek = $carbonDate->dayOfWeek;

        // Vérification Dimanche fermé
        if ($dayOfWeek === Carbon::SUNDAY) {
            return [];
        }

        // Définition des limites horaires
        $isSaturday = ($dayOfWeek === Carbon::SATURDAY);
        $startLimit = 9; 
        $endLimit = $isSaturday ? 14 : 18; 

        // Pré-récupération des indisponibilités 
        $unavailabilities = Unavailability::where('psychologist_id', $psychologistId)
            ->where('date', $date)
            ->get()
            ->map(fn($u) => [
                'start' => Carbon::parse($date . ' ' . $u->start_time),
                'end'   => Carbon::parse($date . ' ' . $u->end_time)
            ]);

        //Pré-récupération des rendez-vous déjà réservés
        $bookedTimes = Appointment::where('psychologist_id', $psychologistId)
            ->where('appointmentDate', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('appointmentTime')
            ->flip();

        $freeSlots = [];
        $now = now();
        $isToday = ($date === $now->toDateString());

        // Boucle de génération des créneaux
        for ($hour = $startLimit; $hour < $endLimit; $hour++) {
            $startTimeStr = sprintf('%02d:00:00', $hour);
            $startSlot = Carbon::parse($date . ' ' . $startTimeStr);
            $endSlot = $startSlot->copy()->addHour();

            //Vérification si le créneau est déjà passé (si on est aujourd'hui)
            if ($isToday && $startSlot->lt($now)) {
                continue;
            }

            //Vérification du chevauchement avec les indisponibilités
            $isUnavailable = $unavailabilities->contains(fn($u) => 
                $startSlot->lt($u['end']) && $endSlot->gt($u['start'])
            );
            if ($isUnavailable) continue;

            // Vérification si déjà réservé
            if (isset($bookedTimes[$startTimeStr])) {
                continue;
            }

            $freeSlots[] = [
                'time' => $startSlot->format('H:i'),
                'full_time' => $startTimeStr,
            ];
        }

        return $freeSlots;
    }
}
