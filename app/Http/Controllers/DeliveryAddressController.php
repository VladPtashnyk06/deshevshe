<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryAddressRequest;
use App\Models\DeliveryAddress;

class DeliveryAddressController extends Controller
{
    public function index()
    {
        return DeliveryAddress::all();
    }

    public function store(DeliveryAddressRequest $request)
    {
        return DeliveryAddress::create($request->validated());
    }

    public function show(DeliveryAddress $deliveryAddress)
    {
        return $deliveryAddress;
    }

    public function update(DeliveryAddressRequest $request, DeliveryAddress $deliveryAddress)
    {
        $deliveryAddress->update($request->validated());

        return $deliveryAddress;
    }

    public function destroy(DeliveryAddress $deliveryAddress)
    {
        $deliveryAddress->delete();

        return response()->json();
    }
}
