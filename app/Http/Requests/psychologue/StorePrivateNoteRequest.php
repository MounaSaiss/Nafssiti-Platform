<?php

namespace App\Http\Requests\psychologue;

use Illuminate\Foundation\Http\FormRequest;

class StorePrivateNoteRequest extends FormRequest
{
    public function authorize(): bool {
         return true; 
        }

    public function rules(): array
    {
        return [
            'content' => 'required|string|min:3'
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Le contenu de la note est obligatoire.',
            'content.min' => 'La note doit contenir au moins 3 caractères.',
        ];
    }
}
