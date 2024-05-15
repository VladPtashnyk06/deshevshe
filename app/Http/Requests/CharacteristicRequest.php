<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CharacteristicRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'height' => ['required', 'integer'],
            'width' => ['required', 'integer'],
            'length' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
