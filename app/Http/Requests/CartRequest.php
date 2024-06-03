<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => ['required'],
            'color_id' => ['required'],
            'size_id' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
