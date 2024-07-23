<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Producer;
use App\Models\Product;
use App\Models\TopProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TopProductController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $topProducts = TopProduct::orderBy('count_purchased', 'desc')->paginate(25);
        return view('admin.top-products.index', compact('topProducts'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $codes = Product::select('code')->distinct()->pluck('code');
        $categories = Category::all();
        $producers = Producer::all();
        $queryParams = $request->only(['code', 'category_id', 'producer_id', 'title']);
        $filteredParams = array_filter($queryParams);
        $query = Product::query();

        if (isset($filteredParams['code'])) {
            $query->where('code', 'LIKE', '%' . $filteredParams['code'] . '%');
        }

        if (isset($filteredParams['title'])) {
            $query->where('title', 'LIKE', '%' . $filteredParams['title'] . '%');
        }

        if (isset($filteredParams['producer_id'])) {
            $query->where('producer_id', $filteredParams['producer_id']);
        }

        if (isset($filteredParams['category_id'])) {
            $query->where('category_id', $filteredParams['category_id']);
        }

        $excludedProductIds = TopProduct::pluck('product_id')->toArray();

        $query->whereNotIn('id', $excludedProductIds);

        $products = $query->paginate(25);
        return view('admin.top-products.create', compact('codes', 'categories', 'producers', 'products'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Product $product)
    {
        TopProduct::create([
            'product_id' => $product->id,
        ]);
        return redirect()->route('top-product.index');
    }

    public function edit(TopProduct $topProduct)
    {
        return view('admin.top-products.edit', compact('topProduct'));
    }

    public function update(Request $request, TopProduct $topProduct)
    {
        $topProduct->update([
            'count_purchased' => $request->post('count_purchased'),
        ]);
        return redirect()->route('top-product.index');
    }

    /**
     * @param TopProduct $topProduct
     * @return RedirectResponse
     */
    public function destroy(TopProduct $topProduct)
    {
        $topProduct->delete();
        return back();
    }
}
