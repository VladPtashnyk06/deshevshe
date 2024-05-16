<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCommentRequest;
use App\Models\BlogComment;

class BlogCommentController extends Controller
{
    public function commentStore(BlogCommentRequest $request) {
        BlogComment::create($request->validated());
        return redirect()->route('site.blog.index');
    }
}
