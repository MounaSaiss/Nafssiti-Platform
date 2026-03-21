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
        ];
    }

    public function messages(): array
    {
        return [
            'psychologist_id.required' => 'Le psychologue est requis.',
            'availability_id.required' => 'Le créneau de disponibilité est requis.',
            'appointment_time.required' => 'L\'heure du rendez-vous est requise.',
        ];
    }
}
