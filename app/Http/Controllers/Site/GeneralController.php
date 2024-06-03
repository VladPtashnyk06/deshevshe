<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\RecProduct;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $recommendProducts = RecProduct::all();
        foreach ($recommendProducts as $recommendProduct) {
            if ($recommendProduct->count_views > 0) {
                $recProducts[] = $recommendProduct;
            }
        }
        if (empty($recProducts)) {
            $recProducts = [];
        }

        $recentlyViewedProducts = session()->get('recentlyViewedProducts');
        if (!empty($recentlyViewedProducts)) {
            foreach ($recentlyViewedProducts as $product) {
                foreach ($product as $idProduct) {
                    $viewedProducts[] = Product::find($idProduct);
                }
            }
        } else {
            $viewedProducts = [];
        }

        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $newProducts = Product::where('created_at', '>=', $thirtyDaysAgo)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $blogs = Blog::all()->sortByDesc('created_at');

        return view('site.index', compact('recProducts', 'viewedProducts', 'blogs', 'newProducts'));
    }
    public function catalog(Request $request)
    {
        $queryParams = $request->only(['category_id']);
        $filteredParams = array_filter($queryParams);
        $query = Product::query();

        if (isset($filteredParams['category_id'])) {
            $query->where('category_id', $filteredParams['category_id']);
        }

        $categories = Category::with(['children' => function ($query) {
            $query->orderBy('level', 'asc');
        }])
            ->whereNull('parent_id')
            ->orderBy('level', 'asc')
            ->get();
        $products = $query->get();
        return view('site.catalog.first-part-catalog', compact('products', 'categories'));
    }

    /**
     * @param Category $category
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function show(Category $category)
    {
        $products = Product::where('category_id', $category->id)->get();

        if (!$products->count() > 0) {
            $categories = Category::where('parent_id', $category->id)->get();
        } else {
            $categories = [];
        }

        return view('site.product.cards-products', compact('products', 'categories'));
    }
}
