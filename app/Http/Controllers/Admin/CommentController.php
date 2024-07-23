<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::paginate(25);
        return view('admin.comments.index', compact('comments'));
    }

    public function create()
    {
        return view('admin.comments.create');
    }

    public function store(CommentRequest $request)
    {
        Comment::create($request->validated());
        return redirect()->route('comment.index');
    }

    public function edit(Comment $comment)
    {
        return view('admin.comments.edit', compact('comment'));
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());

        return redirect()->route('comment.index');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back();
    }
}
