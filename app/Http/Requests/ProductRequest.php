<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => ['required'],
            'producer_id' => ['required'],
            'status_id' => ['required'],
            'size_id' => ['required'],
            'color_id' => ['required'],
            'package_id' => ['required'],
            'material_id' => ['nullable'],
            'characteristic_id' => ['nullable'],
            'title' => ['required'],
            'description' => ['required'],
            'quantity' => ['required', 'integer', 'min:1'],
            'code' => ['required', 'integer', 'min:1'],
            'model' => ['nullable'],
            'product_promotion' => ['nullable', 'boolean'],
            'pair' => ['required', 'integer', 'min:1'],
            'rec_pair' => ['required', 'integer', 'min:1'],
            'package' => ['nullable', 'integer', 'min:1'],
            'rec_package' => ['nullable', 'integer', 'min:1'],
            'retail' => ['required', 'integer', 'min:1'],
            'top_product' => ['nullable', 'boolean'],
            'rec_product' => ['nullable', 'boolean'],
            'main_image' => ['required', 'image', 'mimes:jpg,jpeg,png,bmp,gif,webp,svg', 'max:5120'],
            'alt_for_main_image' => ['nullable', 'string', 'max:255'],
            'additional.*.image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,bmp,gif,webp,svg', 'max:5120'],
            'additional.*.alt' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
