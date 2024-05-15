<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'unique:categories,title'],
            'parent_id' => ['nullable', 'exists:categories,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
