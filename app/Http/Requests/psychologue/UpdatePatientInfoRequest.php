<?php

namespace App\Http\Requests\psychologue;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        // On autorise par défaut, la sécurité est déjà gérée par le middleware psychologue
        return true;
    }

    public function rules(): array
    {
        return [
            'date_of_birth' => 'nullable|date|before:today',
            'problematique_principale' => 'nullable|string|max:1000'
        ];
    }

    public function messages(): array
    {
        return [
            'date_of_birth.date' => 'La date de naissance doit être une date valide.',
            'date_of_birth.before' => 'La date de naissance ne peut pas être dans le futur.',
            'problematique_principale.string' => 'La problématique doit être du texte.',
        ];
    }
}
