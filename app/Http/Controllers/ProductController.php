<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Characteristic;
use App\Models\Color;
use App\Models\Material;
use App\Models\Package;
use App\Models\Producer;
use App\Models\Product;
use App\Models\Size;
use App\Models\Status;
use Illuminate\Http\Request;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();
        $codes = Product::select('code')->distinct()->pluck('code');
        $producers = Producer::all();
        $queryParams = $request->only(['code', 'producer_id', 'top_product', 'product_promotion', 'rec_product']);
        $filteredParams = array_filter($queryParams);
        $query = Product::query();

        if (isset($filteredParams['code'])) {
            $query->where('code', $filteredParams['code']);
        }

        if (isset($filteredParams['producer_id'])) {
            $query->where('producer_id', $filteredParams['producer_id']);
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

        if (isset($filteredParams['rec_product'])) {
            if ($filteredParams['rec_product'] == 1) {
                $query->where('rec_product', $filteredParams['rec_product']);
            } else {
                $query->where('rec_product', 0);
            }
        }

        $products = $query->get();
        return view('admin.products.index', compact('products', 'codes', 'producers'));
    }

    public function allNeeds($view, $idProduct = '')
    {
        $categories = Category::all();
        $colors = Color::all();
        $producers = Producer::all();
        $sizes = Size::all();
        $packages = Package::all();
        $statuses = Status::all();
        $materials = Material::all();
        $characteristics = Characteristic::all();
        if ($idProduct != '') {
            $product = Product::find($idProduct);
        } else {
            $product = Product::all();
        }

        return view('admin.products.'.$view.'', compact('categories', 'colors', 'producers', 'sizes', 'packages', 'product', 'statuses', 'materials', 'characteristics'));
    }

    public function create() {
        return $this->allNeeds('create');
    }

    public function store(ProductRequest $request)
    {
        $newProduct = Product::create($request->validated());
        $newProduct->addMedia($request->validated('main_image'))->withCustomProperties([
            'alt' => $request->validated('alt_for_main_image'),
            'main_image' => 1
        ])->toMediaCollection($newProduct->id);

        if ($request->post('additional')) {
            foreach ($request->validated('additional') as $imageData) {
                if (isset($imageData['image'])) {
                    $newProduct->addMedia($imageData['image'])->withCustomProperties([
                        'alt' => $imageData['alt'],
                        'main_image' => 0
                    ])->toMediaCollection($newProduct->id);
                }
            }
        }
        return redirect()->route('product.index');
    }

    public function edit(Product $product)
    {
        $id = $product->id;
        return $this->allNeeds('edit', $id);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        if ($request->validated('main_media_id')) {
            $media = Media::find($request->validated('main_media_id'));
            $media->collection_name = $product->id;
            $media->custom_properties = [
                'alt' => $request->validated('alt_for_main_image'),
                'main_image' => 1
            ];
            $media->save();
        }

        if ($request->validated('additional_image')) {
            if (!empty($request->validated('additional_image'))) {
                $media = $request->validated('additional_image');
                foreach ($media as $key => $fields) {
                    $media = Media::find($key);
                    $media->collection_name = $product->id;
                    $media->custom_properties = [
                        'alt' => $fields['alt'],
                        'main_image' => 0
                    ];
                    $media->save();
                }
            }
        }

        if ($request->validated('additional')) {
            foreach ($request->validated('additional') as $imageData) {
                if (isset($imageData['image'])) {
                    $product->addMedia($imageData['image'])->withCustomProperties([
                        'alt' => $imageData['alt'],
                        'main_image' => 0
                    ])->toMediaCollection($product->id);
                }
            }
        }

        if ($request->validated('deleted_main_image')) {
            $idDeletedPoster = $request->validated('deleted_main_image');
            Media::find($idDeletedPoster)->delete();
        }

        if ($request->validated('main_image')) {
            $product->addMedia($request->validated('main_image'))->withCustomProperties([
                'alt' => $request->validated('alt_for_main_image'),
                'main_image' => 1
            ])->toMediaCollection($product->id);
        }

        return redirect()->route('product.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('product.index');
    }

    public function destroyMedia($id)
    {
        Media::find($id)->delete();
        return back();
    }
}
