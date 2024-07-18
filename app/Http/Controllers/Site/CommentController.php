<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return view('site.comments.comment', compact('comments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['string', 'required'],
            'comment' => ['string', 'required'],
            'email' => ['email', 'required'],

        ]);
        $nameAndLastName = explode(' ', $request->post('name'));
        $name = $nameAndLastName[0];
        $lastName = $nameAndLastName[1];
        Comment::create([
            'name' => $name,
            'last_name' => $lastName,
            'comment' => $request->post('comment'),
            'email' => $request->post('email'),
        ]);

        return redirect()->route('site.comment.index');
    }
}
