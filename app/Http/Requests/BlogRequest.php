<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'description' => ['required'],
            'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,bmp,gif,webp,svg', 'max:5120'],
            'main_media_id' => ['nullable'],
            'deleted_main_image' => ['nullable'],
            'alt' => ['nullable', 'string'],
            'count_views' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
