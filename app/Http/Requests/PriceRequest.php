<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:producers'],
            'pair' => ['required', 'integer'],
            'rec_pair' => ['required', 'integer'],
            'package' => ['nullable', 'integer'],
            'rec_package' => ['nullable', 'integer'],
            'retail' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
