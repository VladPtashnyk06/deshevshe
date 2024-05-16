<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'unique:statuses,title'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
