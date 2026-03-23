<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpecialityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:specialities',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'La désignation de la spécialité est obligatoire.',
            'name.unique' => 'Cette spécialité existe déjà.',
        ];
    }
}
