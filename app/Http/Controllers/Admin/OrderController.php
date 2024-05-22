<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return Order::all();
    }

    public function create()
    {
        return view('site.orders.create');
    }

    public function store(OrderRequest $request)
    {
        return Order::create($request->validated());
    }

    public function show(Order $order)
    {
        return $order;
    }

    public function update(OrderRequest $request, Order $order)
    {
        $order->update($request->validated());

        return $order;
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json();
    }
}
