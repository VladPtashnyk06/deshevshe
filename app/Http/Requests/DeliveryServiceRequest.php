<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryServiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'delivery_title' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
