<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderEditFirstRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'currency' => ['required', 'string'],
            'user_name' => ['required', 'string'],
            'user_last_name' => ['required', 'string'],
            'user_phone' => ['required'],
            'user_email' => ['nullable']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
