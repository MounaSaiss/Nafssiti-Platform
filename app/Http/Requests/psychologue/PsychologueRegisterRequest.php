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
            'specialization' => 'required|string|max:255',
            'city' => 'required|string',
            'experienceYears' => 'required|integer',
            'pricePerSession' => 'required|numeric',
            'consultationType' => 'required|string',
            'certificate_files' => 'nullable|array',
            'certificate_files.*' => 'nullable|file',
            'certificate_links' => 'nullable|array',
            'certificate_links.*' => 'nullable|url',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $files = $this->file('certificate_files');
            $validFiles = [];
            if (is_array($files)) {
                foreach ($files as $file) {
                    if ($file && $file->isValid()) {
                        $validFiles[] = $file;
                    }
                }
            }

            $links = $this->input('certificate_links');
            $validLinks = is_array($links) ? array_filter($links, fn($l) => !empty(trim($l))) : [];

            if (empty($validFiles) && empty($validLinks)) {
                $validator->errors()->add('certificates', 'Vous devez insérer au moins un certificat valide (fichier ou lien).');
            }
        });
    }
}
