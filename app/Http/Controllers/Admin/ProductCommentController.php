<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCommentRequest;
use App\Http\Requests\ProductCommentRequest;
use App\Models\BlogComment;
use App\Models\Product;
use App\Models\ProductComment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class ProductCommentController extends Controller
{
    /**
     * @param Product $product
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Product $product)
    {
        $comments = ProductComment::where('product_id', $product->id)->get();
        return view('admin.products.comments.index', compact('comments'));
    }

    /**
     * @param ProductComment $productComment
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create(ProductComment $productComment)
    {
        return view('admin.products.comments.create', compact('productComment'));
    }

    /**
     * @param ProductCommentRequest $request
     * @return RedirectResponse
     */
    public function store(ProductCommentRequest $request)
    {
        ProductComment::create($request->validated());
        return redirect()->route('product.index');
    }

    /**
     * @param ProductComment $productComment
     * @return RedirectResponse
     */
    public function destroy(ProductComment $productComment)
    {
        $productComment->delete();

        return back();
    }
}
