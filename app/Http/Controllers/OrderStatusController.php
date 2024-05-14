<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStatusRequest;
use App\Models\OrderStatus;

class OrderStatusController extends Controller
{
    public function index()
    {
        return OrderStatus::all();
    }

    public function store(OrderStatusRequest $request)
    {
        return OrderStatus::create($request->validated());
    }

    public function show(OrderStatus $orderStatus)
    {
        return $orderStatus;
    }

    public function update(OrderStatusRequest $request, OrderStatus $orderStatus)
    {
        $orderStatus->update($request->validated());

        return $orderStatus;
    }

    public function destroy(OrderStatus $orderStatus)
    {
        $orderStatus->delete();

        return response()->json();
    }
}
