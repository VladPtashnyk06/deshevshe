<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => ['nullable', 'string'],
            'advantages' => ['nullable', 'string'],
            'outfit' => ['nullable', 'string'],
            'measurements' => ['nullable', 'string'],
            'size_chart_img' => ['nullable', 'image', 'mimes:jpg,jpeg,png,bmp,gif,webp,svg', 'max:5120'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
