<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCommentRequest;
use App\Models\BlogComment;
use App\Models\ProductComment;

class ProductCommentController extends Controller
{
    public function store(ProductCommentRequest $request)
    {
        ProductComment::create($request->validated());
        return back();
    }
}
