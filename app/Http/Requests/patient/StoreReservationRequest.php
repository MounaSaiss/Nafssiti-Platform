<?php

namespace App\Http\Requests\patient;

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
            'availability_id' => 'required|exists:availabilities,id',
            'appointment_time' => 'required',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'psychologist_id.required' => 'Le psychologue est requis.',
            'availability_id.required' => 'Le créneau de disponibilité est requis.',
            'appointment_time.required' => 'L\'heure du rendez-vous est requise.',
            'notes.max' => 'Les remarques ne doivent pas dépasser 1000 caractères.',
        ];
    }
}
