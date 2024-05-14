<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryAddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'region_id' => ['required', 'exists:regions'],
            'city' => ['required'],
            'address' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
