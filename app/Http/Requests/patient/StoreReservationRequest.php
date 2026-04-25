<?php

namespace App\Http\Requests\patient;

use App\Rules\ValidConsultationSlot;
use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'psychologist_id' => 'required|exists:psychologists,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => [
                'required',
                new ValidConsultationSlot($this->psychologist_id, $this->appointment_date),
            ],
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'psychologist_id.required' => 'Le psychologue est requis.',
            'appointment_date.required' => 'La date du rendez-vous est requise.',
            'appointment_date.after_or_equal' => 'La date ne peut pas être dans le passé.',
            'appointment_time.required' => 'L\'heure du rendez-vous est requise.',
            'notes.max' => 'Les remarques ne doivent pas dépasser 1000 caractères.',
        ];
    }
}
