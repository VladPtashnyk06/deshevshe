<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReletedProductRequest;
use App\Models\Category;
use App\Models\Price;
use App\Models\Producer;
use App\Models\Product;
use App\Models\RelatedProduct;
use Illuminate\Http\Request;

class RelatedProductController extends Controller
{
    public function index(Product $product)
    {
        $relatedProducts = RelatedProduct::where('product_id', $product->id)->get();
        return view('admin.products.relatedProducts.index', compact('relatedProducts', 'product'));
    }

    public function create(Request $request, Product $product)
    {
        $codes = Product::select('code')->distinct()->pluck('code');
        $categories = Category::all();
        $producers = Producer::all();
        $queryParams = $request->only(['code', 'category_id', 'producer_id']);
        $filteredParams = array_filter($queryParams);
        $query = Product::query();

        if (isset($filteredParams['code'])) {
            $query->where('code', 'LIKE', '%' . $filteredParams['code'] . '%');
        }

        if (isset($filteredParams['producer_id'])) {
            $query->where('producer_id', $filteredParams['producer_id']);
        }

        if (isset($filteredParams['category_id'])) {
            $query->where('category_id', $filteredParams['category_id']);
        }

        $mainProduct = $product;
        $products = $query->paginate(25);
        return view('admin.products.relatedProducts.create', compact('mainProduct', 'products', 'codes', 'categories', 'producers'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'related_product_id' => 'required|exists:products,id',
        ]);

        $exists = RelatedProduct::where('product_id', $product->id)
            ->where('related_product_id', $request->post('related_product_id'))
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Такий товар вже є супутнім']);
        } else {
            RelatedProduct::create([
                'product_id' => $product->id,
                'related_product_id' => $request->post('related_product_id'),
            ]);
            return response()->json(['success' => true]);
        }
    }

    public function destroy(RelatedProduct $relatedProduct)
    {
        $relatedProduct->delete();

        return back();
    }
}
