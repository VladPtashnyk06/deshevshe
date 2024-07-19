<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer'],
            'title' => ['required'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'level' => ['nullable', 'integer'],
            'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,bmp,gif,webp,svg', 'max:5120'],
            'main_media_id' => ['nullable'],
            'deleted_main_image' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
