<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'blog_id' => ['required'],
            'parent_comment_id' => ['nullable', 'integer'],
            'level' => ['required', 'integer'],
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
