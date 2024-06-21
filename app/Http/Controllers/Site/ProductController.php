<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Rating;
use App\Models\RecProduct;
use App\Models\RelatedProduct;
use Carbon\Carbon;
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
        } else {
            RecProduct::create(['product_id' => $product->id]);
        }

        if (!empty(session()->get('recentlyViewedProducts'))) {
            $recentlyViewedProducts = session()->get('recentlyViewedProducts', []);

            if (!in_array($product->id, $recentlyViewedProducts)) {
                $recentlyViewedProducts[] = $product->id;
                session()->put('recentlyViewedProducts', $recentlyViewedProducts);
            }
        } else {
            $recentlyViewedProducts[] = $product->id;
            session()->put('recentlyViewedProducts', $recentlyViewedProducts);
        }

        $likedProduct = false;
        $likedProducts = session()->get('likedProducts', []);
        if (in_array($product->id, $likedProducts)) {
            $likedProduct = true;
        }

        $relatedProducts = RelatedProduct::where('product_id', $product->id)->get();

        return view('site.product.card-product-one', compact('product', 'likedProduct', 'relatedProducts'));
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
            foreach ($recentlyViewedProducts as $idProduct) {
                $viewedProducts[] = Product::find($idProduct);
            }
        }

        $likedProducts = session()->get('likedProducts', []);

        return view('site.product.viewed-products', compact('viewedProducts', 'likedProducts'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function recProducts(Request $request)
    {
        $sort = $request->get('sort', 'newest');
        $query = RecProduct::query();

        switch ($sort) {
            case 'price_asc':
                $query->join('prices', 'rec_products.product_id', '=', 'prices.product_id')
                    ->select('rec_products.*', 'prices.pair as price')
                    ->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->join('prices', 'rec_products.product_id', '=', 'prices.product_id')
                    ->select('rec_products.*', 'prices.pair as price')
                    ->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->join('products', 'rec_products.product_id', '=', 'products.id')
                    ->select('rec_products.*', 'products.title as title')
                    ->orderBy('title', 'asc');
                break;
            case 'name_desc':
                $query->join('products', 'rec_products.product_id', '=', 'products.id')
                    ->select('rec_products.*', 'products.title as title')
                    ->orderBy('title', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $recommendProducts = $query->get();
        $recProducts = [];

        foreach ($recommendProducts as $recommendProduct) {
            if ($recommendProduct->count_views > 0) {
                $recProducts[] = $recommendProduct;
            }
        }

        $likedProducts = session()->get('likedProducts', []);

        return view('site.product.rec-products', compact('recProducts', 'likedProducts'));
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

    public function newProducts(Request $request)
    {
        $sort = $request->get('sort', 'newest');
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $query = Product::query();

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

        $newProducts = $query->where('products.created_at', '>=', $thirtyDaysAgo)->get();
        $likedProducts = session()->get('likedProducts', []);

        return view('site.product.new-products', compact('newProducts', 'likedProducts'));
    }

    public function rateProduct(Request $request, Product $product)
    {
        $rating = $request->input('rating');

        Rating::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ],
            [
                'rating' => $rating
            ]
        );

        $newRating = $product->ratings()->avg('rating');
        $product->update(['rating' => $newRating]);

        return response()->json(['success' => true, 'newRating' => $newRating]);
    }

    public function likedProduct(Product $product)
    {
        $likedProducts = session()->get('likedProducts', []);
        if (!in_array($product->id, $likedProducts)) {
            $likedProducts[] = $product->id;
            session()->put('likedProducts', $likedProducts);
        }

        return response()->json(['success' => true]);
    }

    public function unlinkedProduct(Product $product)
    {
        $likedProducts = session()->get('likedProducts', []);
        if (($key = array_search($product->id, $likedProducts)) !== false) {
            unset($likedProducts[$key]);
        }
        session()->put('likedProducts', $likedProducts);

        return response()->json(['success' => true]);
    }

    public function likedProducts()
    {
        $likedProducts = session()->get('likedProducts', []);
        $products = [];
        foreach ($likedProducts as $productId) {
            $product = Product::find($productId);
            $products[] = $product;
        }
        return view('site.product.liked-products', compact('products'));
    }

    public function promotionalProducts(Request $request)
    {
        $sort = $request->get('sort', 'newest');
        $query = Product::query();

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

        $promotionalProducts = $query->where('product_promotion', 1)->get();
        $likedProducts = session()->get('likedProducts', []);

        return view('site.product.promotional-products', compact('promotionalProducts', 'likedProducts'));
    }
}
