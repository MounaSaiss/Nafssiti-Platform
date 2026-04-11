<?php

namespace App\Http\Requests\patient;

use Illuminate\Foundation\Http\FormRequest;

class PatientAppointmentsFilterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'status' => 'nullable|string|in:à-venir,en-attente,refuse',
        ];
    }
}
