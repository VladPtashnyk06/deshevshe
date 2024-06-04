<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'comment' => ['required'],
            'name' => ['required'],
            'last_name' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
