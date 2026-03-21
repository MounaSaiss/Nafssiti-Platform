<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class UserFilterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'search' => 'nullable|string|max:100',
            'role' => 'nullable|string|in:patient,psychologue',
        ];
    }
}
