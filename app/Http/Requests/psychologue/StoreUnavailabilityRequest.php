<?php

namespace App\Http\Requests\psychologue;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnavailabilityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date|after_or_equal:today',
            'start_time' => [
                'required',
                function ($attribute, $value, $fail) {
                    $date = $this->input('date');
                    if ($date === \Carbon\Carbon::now()->toDateString()) {
                        if ($value <= \Carbon\Carbon::now()->toTimeString()) {
                            $fail('Vous ne pouvez pas signaler une indisponibilité dans le passé pour aujourd\'hui.');
                        }
                    }
                },
            ],
            'end_time' => 'required|after:start_time',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'date.after_or_equal' => 'La date doit être aujourd\'hui ou une date future.',
            'end_time.after' => 'L\'heure de fin doit être après l\'heure de début.',
        ];
    }
}
