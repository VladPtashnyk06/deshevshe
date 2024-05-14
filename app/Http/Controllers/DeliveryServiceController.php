<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryServiceRequest;
use App\Models\DeliveryService;

class DeliveryServiceController extends Controller
{
    public function index()
    {
        return DeliveryService::all();
    }

    public function store(DeliveryServiceRequest $request)
    {
        return DeliveryService::create($request->validated());
    }

    public function show(DeliveryService $deliveryService)
    {
        return $deliveryService;
    }

    public function update(DeliveryServiceRequest $request, DeliveryService $deliveryService)
    {
        $deliveryService->update($request->validated());

        return $deliveryService;
    }

    public function destroy(DeliveryService $deliveryService)
    {
        $deliveryService->delete();

        return response()->json();
    }
}
