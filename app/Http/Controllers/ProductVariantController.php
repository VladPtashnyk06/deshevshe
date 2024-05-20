<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductVariantRequest;
use App\Models\ProductVariant;

class ProductVariantController extends Controller
{
    public function index()
    {
        return ProductVariant::all();
    }

    public function store(ProductVariantRequest $request)
    {
        return ProductVariant::create($request->validated());
    }

    public function show(ProductVariant $productVariant)
    {
        return $productVariant;
    }

    public function update(ProductVariantRequest $request, ProductVariant $productVariant)
    {
        $productVariant->update($request->validated());

        return $productVariant;
    }

    public function destroy(ProductVariant $productVariant)
    {
        $productVariant->delete();

        return response()->json();
    }
}
