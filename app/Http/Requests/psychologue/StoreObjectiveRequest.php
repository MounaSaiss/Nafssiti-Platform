<?php

namespace App\Http\Requests\psychologue;

use Illuminate\Foundation\Http\FormRequest;

class StoreObjectiveRequest extends FormRequest
{
    public function authorize(): bool {
         return true; 
        }

    public function rules(): array
    {
        return [
            'description' => 'required|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'La description de l\'objectif est obligatoire.',
        ];
    }
}
