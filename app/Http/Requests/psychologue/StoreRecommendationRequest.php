<?php

namespace App\Http\Requests\psychologue;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecommendationRequest extends FormRequest
{
    public function authorize(): bool { 
        return true; 
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|min:5'
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Le contenu de la recommandation est obligatoire.',
        ];
    }
}
