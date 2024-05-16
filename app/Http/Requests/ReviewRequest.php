<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users'],
            'product_id' => ['required', 'exists:products'],
            'title' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
