<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryMethodRequest;
use App\Models\DeliveryMethod;

class DeliveryMethodController extends Controller
{
    public function index()
    {
        return DeliveryMethod::all();
    }

    public function store(DeliveryMethodRequest $request)
    {
        return DeliveryMethod::create($request->validated());
    }

    public function show(DeliveryMethod $deliveryMethod)
    {
        return $deliveryMethod;
    }

    public function update(DeliveryMethodRequest $request, DeliveryMethod $deliveryMethod)
    {
        $deliveryMethod->update($request->validated());

        return $deliveryMethod;
    }

    public function destroy(DeliveryMethod $deliveryMethod)
    {
        $deliveryMethod->delete();

        return response()->json();
    }
}
