<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'password' => ['nullable'],
            'password_confirmation' => ['nullable'],
            'comment' => ['nullable'],
            'total_price' => ['required'],
            'currency' => ['required', 'string'],
            'cost_delivery' => ['required', 'string'],
            'region' => ['required', 'string'],
            'cityRefHidden' => ['required', 'string'],
            'branchRefHidden' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'delivery_type' => ['required', 'string']
        ];
    }
}
