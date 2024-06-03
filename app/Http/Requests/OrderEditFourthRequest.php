<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderEditFourthRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payment_method_id' => ['required'],
            'order_status_id' => ['required'],
            'comment' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
