<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\RecProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProductController extends Controller
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

        $blogs = Blog::all()->sortByDesc('created_at');

        return view('site.index', compact('recProducts', 'viewedProducts', 'blogs'));
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

    /**
     * @param Product $product
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function showOneProduct(Product $product)
    {
        $recProduct = RecProduct::where('product_id', $product->id)->first();
        if ($recProduct) {
            $recProduct->update(['count_views' => $recProduct->count_views + 1]);
        }

        if (!empty(session()->get('recentlyViewedProducts'))) {
            $recentlyViewedProducts = session()->get('recentlyViewedProducts', []);
            foreach ($recentlyViewedProducts as $recentlyViewedProduct) {
                foreach ($recentlyViewedProduct as $item) {
                    if ($item == $product->id) {
                        break;
                    } else {
                        $recentlyViewedProducts['product_id'][] = $product->id;
                        session()->put('recentlyViewedProducts', $recentlyViewedProducts);
                    }
                }
            }
        } else {
            $recentlyViewedProducts['product_id'][] = $product->id;
            session()->put('recentlyViewedProducts', $recentlyViewedProducts);
        }

        return view('site.product.card-product-one', compact('product'));
    }


    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function recentlyViewedProducts()
    {
        $recentlyViewedProducts = session()->get('recentlyViewedProducts');
        $viewedProducts = [];
        if (!empty($recentlyViewedProducts)) {
            foreach ($recentlyViewedProducts as $product) {
                foreach ($product as $idProduct) {
                    $viewedProducts[] = Product::find($idProduct);
                }
            }
        }

        return view('site.product.viewed-products', compact('viewedProducts', ));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function recProducts()
    {
        $recommendProducts = RecProduct::all();
        $recProducts = [];
        foreach ($recommendProducts as $recommendProduct) {
            if ($recommendProduct->count_views > 0) {
                $recProducts[] = $recommendProduct;
            }
        }

        return view('site.product.rec-products', compact('recProducts'));
    }

    /**
     * @param $productId
     * @return JsonResponse
     */
    public function getSizes($productId)
    {
        $product = Product::with('productVariants.size')->find($productId);

        $sizeUniqueVariants = $product->productVariants->unique('size_id');

        return response()->json(['sizeVariants' => $sizeUniqueVariants]);
    }

    /**
     * @param $productId
     * @return JsonResponse
     */
    public function getProduct($productId)
    {
        $product = Product::with('productVariants.color')->findOrFail($productId);

        $uniqueVariants = $product->productVariants->unique('color_id');

        return response()->json(['productVariants' => $uniqueVariants]);
    }

}
