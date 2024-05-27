<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderEditSecondRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product.*.quantity_product' => ['required'],
            'additionalProduct.*.code' => ['nullable'],
            'additionalProduct.*.product_variant_id' => ['nullable'],
            'additionalProduct.*.quantity' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
