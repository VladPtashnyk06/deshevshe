<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'unique:categories,title'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
