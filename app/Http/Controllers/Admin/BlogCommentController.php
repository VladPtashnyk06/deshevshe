<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCommentRequest;
use App\Models\BlogComment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BlogCommentController extends Controller
{
    /**
     * @param BlogComment $blogComment
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function commentAnswerCreate(BlogComment $blogComment)
    {
        return view('admin.blogs.commentAnswerCreate', compact('blogComment'));
    }

    /**
     * @param BlogCommentRequest $request
     * @return RedirectResponse
     */
    public function commentAnswerStore(BlogCommentRequest $request)
    {
        BlogComment::create($request->validated());
        return redirect()->route('blog.index');
    }

    /**
     * @param BlogComment $blogComment
     * @return RedirectResponse
     */
    public function destroyComment(BlogComment $blogComment)
    {
        $blogComment->delete();

        return back();
    }
}
