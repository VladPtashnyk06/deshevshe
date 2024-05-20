<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCommentRequest;
use App\Models\ProductComment;

class ProductCommentController extends Controller
{
    public function index()
    {
        return ProductComment::all();
    }

    public function store(ProductCommentRequest $request)
    {
        return ProductComment::create($request->validated());
    }

    public function show(ProductComment $productComment)
    {
        return $productComment;
    }

    public function update(ProductCommentRequest $request, ProductComment $productComment)
    {
        $productComment->update($request->validated());

        return $productComment;
    }

    public function destroy(ProductComment $productComment)
    {
        $productComment->delete();

        return response()->json();
    }
}
