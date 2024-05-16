<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogComment extends Model
{
    protected $fillable = [
        'blog_id',
        'parent_comment_id',
        'level',
        'comment',
        'name',
        'email',
    ];

    public function parent_comment(): BelongsTo
    {
        return $this->belongsTo(BlogComment::class);
    }

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }
}
