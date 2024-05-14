<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceRequest;
use App\Models\Price;

class PriceController extends Controller
{
    public function index()
    {
        return Price::all();
    }

    public function store(PriceRequest $request)
    {
        return Price::create($request->validated());
    }

    public function show(Price $price)
    {
        return $price;
    }

    public function update(PriceRequest $request, Price $price)
    {
        $price->update($request->validated());

        return $price;
    }

    public function destroy(Price $price)
    {
        $price->delete();

        return response()->json();
    }
}
