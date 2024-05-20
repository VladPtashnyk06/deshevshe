<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCommentRequest;
use App\Models\BlogComment;
use Illuminate\Http\RedirectResponse;

class BlogCommentController extends Controller
{
    /**
     * @param BlogCommentRequest $request
     * @return RedirectResponse
     */
    public function commentStore(BlogCommentRequest $request) {
        BlogComment::create($request->validated());
        return redirect()->route('site.blog.index');
    }
}
