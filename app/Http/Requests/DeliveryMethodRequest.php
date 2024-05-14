<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryMethodRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'delivery_title' => ['required'],
            'method_title' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
