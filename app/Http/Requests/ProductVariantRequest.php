<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products'],
            'color_id' => ['required', 'exists:colors'],
            'size_id' => ['required', 'exists:sizes'],
            'quantity' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
