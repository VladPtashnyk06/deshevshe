<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionalRequest;
use App\Models\Category;
use App\Models\Price;
use App\Models\Producer;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Promotional;
use Illuminate\Http\Request;

class PromotionalController extends Controller
{
    public function index()
    {
        $promotionalProducts = Product::where('product_promotion', 1)->get();

        return view('admin.promotional.index', compact('promotionalProducts'));
    }


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

        $products = $query->get();
        return view('admin.promotional.create', compact('codes', 'categories', 'producers', 'products'));
    }

    public function store(Request $request)
    {
        $product = Product::where('id', $request->post('productId'))->first();
        $product->update([
            'product_promotion' => 1
        ]);

        $product->price->update(
            [
                'promotional_price' => $product->price->pair - ($product->price->pair * ($request->post('promotionalRate') / 100)),
                'promotional_rate' => $request->post('promotionalRate')
            ]
        );

        return redirect()->route('promotional.index');
    }

    public function edit(Product $product)
    {
        return view('admin.promotional.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $product->price->update(
            [
                'promotional_price' => $product->price->pair - ($product->price->pair * ($request->post('promotionalRate') / 100)),
                'promotional_rate' => $request->post('promotionalRate')
            ]
        );

        return redirect()->route('promotional.index');
    }

    public function destroy(Product $product)
    {
        $product->update([
            'product_promotion' => 0
        ]);
        $product->price->update([
            'promotional_price' => null,
            'promotional_rate' => null
        ]);
        return back();
    }
}
