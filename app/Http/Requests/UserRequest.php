<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'last_name' => ['required'],
            'phone' => ['required'],
            'email' => ['nullable', 'email', 'max:254'],
            'role' => ['required'],
            'region' => ['nullable'],
            'city' => ['nullable'],
            'address' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
