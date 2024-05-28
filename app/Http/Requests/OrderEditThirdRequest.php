<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderEditThirdRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_name' => ['required', 'string'],
            'user_last_name' => ['required', 'string'],
            'region' => ['required', 'string'],
            'cityRefHidden' => ['required', 'string'],
            'branchRefHidden' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'delivery_type' => ['nullable', 'string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
