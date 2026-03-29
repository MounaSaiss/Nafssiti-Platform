<?php

namespace App\Http\Requests\psychologue;

use Illuminate\Foundation\Http\FormRequest;

class PsychologueRegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'confirm_password' => 'required|string|min:8|confirmed',
            'specialization' => 'required|string|max:255',
            'city' => 'required|string',
            'experienceYears' => 'required|integer',
            'pricePerSession' => 'required|numeric',
            'consultationType' => 'required|string',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'photo' => 'nullable|image',
        ];
    }
}
