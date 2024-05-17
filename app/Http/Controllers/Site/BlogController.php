<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlogController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $blogs = Blog::all()->sortByDesc('created_at');

        return view('site.blogs.index', compact('blogs'));
    }

    /**
     * @param Blog $blog
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function show(Blog $blog)
    {
        $blog->update([
            'count_views' => $blog->count_views + 1,
        ]);
        return view('site.blogs.one-blog', compact('blog'));
    }

    /**
     * @param BlogRequest $request
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(BlogRequest $request)
    {
        $newBlog = Blog::create($request->validated());
        if (!empty($request->validated('main_image'))) {
            $newBlog->addMedia($request->validated('main_image'))->withCustomProperties([
                'alt' => $request->validated('alt'),
            ])->toMediaCollection('blog'.$newBlog->id);
        }

        return redirect()->route('blog.index');
    }

    public function showComments(Blog $blog)
    {
        $comments = $blog->comments()->get();
        return view('admin.blogs.blogComments', compact('blog', 'comments'));
    }
}
