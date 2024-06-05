<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
//            'productId' => ['required', 'integer'],
//            'productVariantId' => ['required', 'integer'],
//            'promotionalRate' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
