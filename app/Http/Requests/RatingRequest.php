<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => ['required'],
            'user_id' => ['required'],
            'rating' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
