<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users'],
            'order_status_id' => ['required', 'exists:order_statuses'],
            'delivery_method_id' => ['required', 'exists:delivery_methods'],
            'payment_method_id' => ['required', 'exists:payment_methods'],
            'delivery_address_id' => ['required', 'exists:delivery_addresses'],
            'total_price' => ['required'],
            'comment' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
