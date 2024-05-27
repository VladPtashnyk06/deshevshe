<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderSmallRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['nullable'],
            'delivery_method_id' => ['nullable',],
            'payment_method_id' => ['required'],
            'delivery_address_id' => ['nullable'],
            'user_name' => ['required', 'string'],
            'user_last_name' => ['required', 'string'],
            'user_phone' => ['required', 'string'],
            'user_email' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
