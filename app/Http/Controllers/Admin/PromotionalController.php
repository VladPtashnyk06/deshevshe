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
        $promotionalProducts = Promotional::with(['product', 'productVariant'])
            ->get()
            ->map(function ($promotional) {
                return [
                    'product' =>$promotional->product,
                    'product_variant' => $promotional->productVariant,
                    'promotional_id' => $promotional->id,
                    'promotional_price' => $promotional->promotional_price,
                    'promotional_rate' => $promotional->promotional_rate,
                ];
            });

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

    public function store(PromotionalRequest $request)
    {
        $product = Product::where('id', $request->validated('productId'))->first();
        $product->update([
            'product_promotion' => 1
        ]);
        $productPrice = $product->price;
        $promotionalRate = $request->validated('promotionalRate');
        $promotionalPrice = $productPrice->pair - ($productPrice->pair * ($promotionalRate / 100));

        Promotional::updateOrCreate(
            [
                'product_id' => $request->validated('productId'),
                'product_variant_id' => $request->validated('productVariantId'),
                'promotional_price' => $promotionalPrice,
                'promotional_rate' => $promotionalRate
            ]
        );

        return redirect()->route('promotional.index');
    }

    public function edit(Promotional $promotional)
    {
        $promotional->load('product', 'productVariant');

        $promotionalProduct = [
            'product' => $promotional->product,
            'product_variant' => $promotional->productVariant,
            'promotional_id' => $promotional->id,
            'promotional_price' => $promotional->promotional_price,
            'promotional_rate' => $promotional->promotional_rate,
        ];

        return view('admin.promotional.edit', compact('promotionalProduct'));
    }

    public function update(Request $request, Promotional $promotional)
    {
        $productPrice = $promotional->product->price->pair;
        $promotional->update([
            'promotional_price' => $productPrice - ($productPrice * ($request->post('promotionalRate') / 100)),
            'promotional_rate' => $request->post('promotionalRate')
        ]);

        return redirect()->route('promotional.index');
    }

    public function destroy(Promotional $promotional)
    {
        $promotional->delete();
        return back();
    }
}
