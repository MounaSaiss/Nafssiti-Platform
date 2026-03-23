<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentsFilterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'search' => 'nullable|string|max:100',
            'status' => 'nullable|string|in:all,pending,confirmed,rejected,completed',
        ];
    }
}
