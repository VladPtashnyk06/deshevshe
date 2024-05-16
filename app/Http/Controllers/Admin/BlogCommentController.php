<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCommentRequest;
use App\Models\BlogComment;

class BlogCommentController extends Controller
{
    public function commentAnswerCreate(BlogComment $blogComment)
    {
        return view('admin.blogs.commentAnswerCreate', compact('blogComment'));
    }

    public function commentAnswerStore(BlogCommentRequest $request)
    {
        BlogComment::create($request->validated());
        return redirect()->route('blog.index');
    }

    public function destroyComment(BlogComment $blogComment)
    {
        $blogComment->delete();

        return back();
    }
}
