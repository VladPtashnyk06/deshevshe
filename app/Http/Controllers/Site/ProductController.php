<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
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
        if (!empty($recentlyViewedProducts)) {
            foreach ($recentlyViewedProducts as $product) {
                foreach ($product as $idProduct) {
                    $viewedProducts[] = Product::find($idProduct);
                }
            }
        } else {
            $viewedProducts = [];
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
        foreach ($recommendProducts as $recommendProduct) {
            $recProducts[] = $recommendProduct;
        }

        return view('site.product.rec-products', compact('recProducts'));
    }

    /**
     * @param $color_id
     * @return JsonResponse
     */
    public function getSizes($color_id)
    {
        $productVariants = ProductVariant::where('color_id', $color_id)->with('size')->get();
        $sizes = $productVariants->map(function($variant) {
            return [
                'size_id' => $variant->size->id,
                'size_title' => $variant->size->title,
            ];
        });
        return response()->json($sizes);
    }

    /**
     * @param $productId
     * @return JsonResponse
     */
    public function getProduct($productId)
    {
        $product = Product::with('productVariants.color')->findOrFail($productId);

        return response()->json(['productVariants' => $product->productVariants]);
    }
}
