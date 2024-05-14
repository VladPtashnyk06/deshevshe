<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories'],
            'title' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
