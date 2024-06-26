<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Color;
use App\Models\Comment;
use App\Models\Producer;
use App\Models\Product;
use App\Models\RecProduct;
use App\Models\Size;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
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
            foreach ($recentlyViewedProducts as $idProduct) {
                $viewedProducts[] = Product::find($idProduct);
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

        $likedProducts = session()->get('likedProducts', []);

        $comments = Comment::orderByDesc('created_at')->take(4)->get();

        $promotionalProducts = Product::where('product_promotion', 1)->get();

        return view('site.index', compact('recProducts', 'viewedProducts', 'blogs', 'newProducts', 'likedProducts', 'comments', 'promotionalProducts'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
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
    public function show(Category $category, Request $request)
    {
        $sort = $request->get('sort', 'newest');
        $color_id = $request->get('color_id');
        $size_id = $request->get('size_id');
        $producer_id = $request->get('producer_id');
        $status_id = $request->get('status_id');

        $query = Product::where('category_id', $category->id);

        if ($color_id) {
            $query->whereHas('productVariants.color', function ($q) use ($color_id) {
                $q->where('id', $color_id);
            });
        }

        if ($size_id) {
            $query->whereHas('productVariants.size', function ($q) use ($size_id) {
                $q->where('id', $size_id);
            });
        }

        if ($producer_id) {
            $query->where('producer_id', $producer_id);
        }

        if ($status_id) {
            $query->where('status_id', $status_id);
        }

        switch ($sort) {
            case 'price_asc':
                $query->join('prices', 'products.id', '=', 'prices.product_id')
                    ->select('products.*', 'prices.pair as price')
                    ->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->join('prices', 'products.id', '=', 'prices.product_id')
                    ->select('products.*', 'prices.pair as price')
                    ->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->orderBy('top_product', 'desc')->get();

        if (!$products->count() > 0) {
            $categories = Category::where('parent_id', $category->id)->get();
        } else {
            $categories = [];
        }

        $colors = Color::all();
        $sizes = Size::all();
        $producers = Producer::all();
        $statuses = Status::all();

        return view('site.product.cards-products', compact('products', 'categories', 'category', 'color_id', 'size_id', 'producers', 'statuses', 'colors', 'sizes'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        $products = Product::where('title', 'LIKE', "%{$query}%")
            ->with('media')
            ->get();

        $results = $products->map(function ($product) {
            $mediaItem = $product->getMedia($product->id)->first(function ($media) {
                return $media->getCustomProperty('main_image') === 1;
            });

            return [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price->pair,
                'currency' => 'UAH',
                'image' => $mediaItem ? $mediaItem->getUrl() : '',
                'alt' => $mediaItem ? $mediaItem->getCustomProperty('alt') : '',
            ];
        });

        return response()->json($results);
    }

}
