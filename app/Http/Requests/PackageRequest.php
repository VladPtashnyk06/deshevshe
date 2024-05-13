<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
