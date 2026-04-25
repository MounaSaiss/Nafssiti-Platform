<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Appointment;
use App\Services\ReservationLogicService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ValidConsultationSlot implements ValidationRule
{
    protected $psychologist_id;
    protected $appointment_date;

    public function __construct($psychologist_id, $appointment_date) {
        $this->psychologist_id = $psychologist_id;
        $this->appointment_date = $appointment_date;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $id = $this->psychologist_id;
        $date = $this->appointment_date;
        $time = $value;

        if (!$id || !$date || !$time) {
            return;
        }

        // Utilisation du service centralisé pour vérifier la disponibilité du psychologue
        $service = app(ReservationLogicService::class);
        $availableSlots = $service->getAvailableSlots($id, $date);

        // On vérifie si l'heure choisie est dans la liste des créneaux libres retournés par le service
        $isAvailable = collect($availableSlots)->contains('full_time', $time);

        if (!$isAvailable) {
            $fail('Ce créneau n\'est plus disponible ou est hors des horaires de travail du praticien.');
            return;
        }

        // Vérification des conflits pour le patient lui-même (Règle spécifique au patient)
        $patient = Auth::user()->patient ?? null;
        if ($patient) {
            $hasConflict = Appointment::where('patient_id', $patient->id)
                ->where('appointmentDate', $date)
                ->where('appointmentTime', $time)
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();

            if ($hasConflict) {
                $fail('Vous avez déjà un rendez-vous prévu à cette heure-là.');
            }
        }
    }
}
