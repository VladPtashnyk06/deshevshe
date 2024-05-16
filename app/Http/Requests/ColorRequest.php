<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'unique:colors,title'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
