<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'unique:packages,title', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
