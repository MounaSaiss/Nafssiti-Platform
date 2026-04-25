<?php

namespace App\Http\Requests\psychologue;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool {
         return true; 
        }

    public function rules(): array
    {
        return [
            'appointmentDate' => 'required|date|after_or_equal:today',
            'appointmentTime' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'appointmentDate.after_or_equal' => 'La date doit être aujourd\'hui ou une date future.',
            'appointmentTime.required' => 'L\'heure est obligatoire.',
        ];
    }
}
