<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Characteristic;
use App\Models\Color;
use App\Models\Material;
use App\Models\Package;
use App\Models\Price;
use App\Models\Producer;
use App\Models\Product;
use App\Models\Size;
use App\Models\Status;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $products = Product::all();
        $categories = Category::where('level', '1')->get();
        $queryParams = $request->only(['category_id']);
        $filteredParams = array_filter($queryParams);
        $query = Product::query();

        if (isset($filteredParams['category_id'])) {
            $query->where('category_id', $filteredParams['category_id']);
        }

        $products = $query->get();
        return view('site.filter.index', compact('products', 'categories'));
    }

    /**
     * @param Category $category
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function show(Category $category)
    {
        $products = Product::where('category_id', $category->id)->get();
        return view('site.product.show', compact('products'));
    }
}
