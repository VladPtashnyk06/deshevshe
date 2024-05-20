<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => ['required'],
            'parent_comment_id' => ['nullable'],
            'user_id' => ['required'],
            'level' => ['required'],
            'comment' => ['required'],
            'name' => ['required'],
            'email' => ['required', 'email', 'max:254'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
