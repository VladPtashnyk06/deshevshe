<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderDetailRequest;
use App\Models\OrderDetail;

class OrderDetailController extends Controller
{
    public function index()
    {
        return OrderDetail::all();
    }

    public function store(OrderDetailRequest $request)
    {
        return OrderDetail::create($request->validated());
    }

    public function show(OrderDetail $orderDetail)
    {
        return $orderDetail;
    }

    public function update(OrderDetailRequest $request, OrderDetail $orderDetail)
    {
        $orderDetail->update($request->validated());

        return $orderDetail;
    }

    public function destroy(OrderDetail $orderDetail)
    {
        $orderDetail->delete();

        return response()->json();
    }
}
