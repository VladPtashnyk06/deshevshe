<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Characteristic;
use App\Models\Color;
use App\Models\Material;
use App\Models\Price;
use App\Models\Producer;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Rating;
use App\Models\TopProduct;
use App\Models\Size;
use App\Models\Status;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $products = Product::all();
        $prices = Price::all();
        $codes = Product::select('code')->distinct()->pluck('code');
        $categories = Category::all();
        $producers = Producer::all();
        $queryParams = $request->only(['code', 'category_id', 'producer_id', 'top_product', 'product_promotion']);
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

        if (isset($filteredParams['top_product'])) {
            if ($filteredParams['top_product'] == 1) {
                $query->where('top_product', $filteredParams['top_product']);
            } else {
                $query->where('top_product', 0);
            }
        }

        if (isset($filteredParams['product_promotion'])) {
            if ($filteredParams['product_promotion'] == 1) {
                $query->where('product_promotion', $filteredParams['product_promotion']);
            } else {
                $query->where('product_promotion', 0);
            }
        }

        $products = $query->paginate(25);
        return view('admin.products.index', compact('products', 'codes', 'producers', 'prices', 'categories'));
    }

    public function show(Product $product)
    {
        if ($product->description) {
            $description = str_replace('&', '<br>', $product->description);
        } else {
            $description = 'Не вказанно';
        }

        if ($product->advantages) {
            $advantagesArray = explode('&', $product->advantages);
            $advantagesArray = array_map('trim', $advantagesArray);
        } else {
            $advantagesArray[] = 'Не вказанно';
        }

        if ($product->outfit) {
            $outfitsArray = explode('&', $product->outfit);
            $outfitsArray = array_map('trim', $outfitsArray);
        } else {
            $outfitsArray[] = 'Не вказанно';
        }

        if ($product->measurements) {
            $measurementsArray = explode('&', $product->measurements);
            $measurementsArray = array_map('trim', $measurementsArray);
        } else {
            $measurementsArray[] = 'Не вказанно';
        }

        return view('admin.products.show', compact('product', 'description', 'advantagesArray', 'outfitsArray', 'measurementsArray'));
    }

    public function ratingProduct(Request $request)
    {
        $prices = Price::all();
        $codes = Product::select('code')->distinct()->pluck('code');
        $categories = Category::all();
        $producers = Producer::all();
        $queryParams = $request->only(['code', 'category_id', 'producer_id', 'top_product', 'product_promotion']);
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

        if (isset($filteredParams['top_product'])) {
            if ($filteredParams['top_product'] == 1) {
                $query->where('top_product', $filteredParams['top_product']);
            } else {
                $query->where('top_product', 0);
            }
        }

        if (isset($filteredParams['product_promotion'])) {
            if ($filteredParams['product_promotion'] == 1) {
                $query->where('product_promotion', $filteredParams['product_promotion']);
            } else {
                $query->where('product_promotion', 0);
            }
        }

        $products = $query->paginate(25);
        return view('admin.products.rating.index', compact('products', 'codes', 'producers', 'prices', 'categories'));
    }

    public function showRatingProduct(Product $product)
    {
        return view('admin.products.rating.show', compact('product'));
    }

    public function editRatingProduct(Product $product)
    {
        return view('admin.products.rating.edit', compact('product'));
    }

    public function updateRatingProduct(Product $product, Request $request)
    {
        $product->update([
            'rating' => $request->post('rating'),
        ]);
        return redirect()->route('product.ratingProduct');
    }

    public function destroyRatingProduct(Rating $rating)
    {
        $productId = $rating->product_id;
        $rating->delete();

        $product = Product::find($productId);

        $newRating = $product->ratings->avg('rating');

        $product->update([
            'rating' => $newRating
        ]);

        return back();
    }


    /**
     * @param $view
     * @param $product
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function allNeeds($view, $product = '')
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $colors = Color::all();
        $producers = Producer::all();
        $sizes = Size::all();
        $statuses = Status::all();
        $materials = Material::all();
        $characteristics = Characteristic::all();
        ($product == '') ? $productVariants = null : $productVariants = ProductVariant::where('product_id', $product->id)->get();;

        return view('admin.products.'.$view.'', compact('categories', 'colors', 'producers', 'sizes', 'product', 'statuses', 'materials', 'characteristics', 'productVariants'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create() {
        return $this->allNeeds('create');
    }

    /**
     * @param ProductRequest $request
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(ProductRequest $request)
    {
        $newProduct = Product::create($request->validated());

        TopProduct::create([
            'product_id' => $newProduct->id,
        ]);

        $productVariantData = $request->validated('productVariant');
        $count = count($productVariantData['color']);

        for ($i = 0; $i < $count; $i++) {
            ProductVariant::create([
                'product_id' => $newProduct->id,
                'color_id' => $productVariantData['color'][$i],
                'size_id' => $productVariantData['size'][$i],
                'quantity' => $productVariantData['quantity'][$i],
            ]);
        }

        $newProduct->addMedia($request->validated('main_image'))->withCustomProperties([
            'alt' => $request->validated('alt_for_main_image'),
            'main_image' => 1
        ])->toMediaCollection($newProduct->id);

        if ($request->post('additional')) {
            foreach ($request->validated('additional') as $imageData) {
                if (isset($imageData['images'])) {
                    $newProduct->addMedia($imageData['images'])->withCustomProperties([
                        'alt' => $imageData['alt'],
                        'main_image' => 0
                    ])->toMediaCollection($newProduct->id);
                }
            }
        }

        Price::create([
            'product_id' => $newProduct->id,
            'pair' => $request->validated('pair'),
            'rec_pair' => $request->validated('rec_pair'),
            'package' => $request->validated('package'),
            'rec_package' => $request->validated('rec_package'),
            'retail' => $request->validated('retail'),
        ]);

        return redirect()->route('product.index');
    }

    /**
     * @param Product $product
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return $this->allNeeds('edit', $product);
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        if ($request->validated('size_chart_img')) {
            $product->addMedia($request->validated('size_chart_img'))->withCustomProperties([
                'alt' => 'розмірна сітка',
                'size_chart' => 1
            ])->toMediaCollection('size_chart_'.$product->id);
        }

        return redirect()->route('product.index');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product)
    {
        Price::where('product_id', $product->id)->delete();
        $product->delete();

        return redirect()->route('product.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroyMedia($id)
    {
        Media::find($id)->delete();
        return back();
    }

    /**
     * @param ProductVariant $productVariant
     * @return RedirectResponse
     */
    public function destroyProductVariant(ProductVariant $productVariant)
    {
        $productVariant->delete();
        return back();
    }
}
