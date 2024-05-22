<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\PaymentMethod;

class OrderController extends Controller
{
    public function index()
    {
        return Order::all();
    }

    public function create()
    {
        $cartItems = \Cart::getContent()->sortBy('id');

        $totalPrice = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->quantity * $item->price);
        }, 0);

        $totalDiscountPrice = $totalPrice;
        $discount = 0;

        if(session()->get('currency') == 'USD') {
            $currencyRateUsd = session()->get('currency_rate_usd');

            if ($totalPrice > (2500 / $currencyRateUsd) && $totalPrice <= (5000 / $currencyRateUsd)) {
                $discount = $totalPrice * 0.10;
                $totalDiscountPrice -= $discount;
            }

            $freeShipping = $totalPrice > (1000 / $currencyRateUsd) && $totalPrice < (2500 / $currencyRateUsd);
            $minimumAmount = 500 / $currencyRateUsd;
            $belowMinimumAmount = $totalPrice < $minimumAmount;
        } elseif(session()->get('currency') == 'EUR') {
            $currencyRateEUR = session()->get('currency_rate_eur');

            if ($totalPrice > (2500 / $currencyRateEUR) && $totalPrice <= (5000 / $currencyRateEUR)) {
                $discount = $totalPrice * 0.10;
                $totalDiscountPrice -= $discount;
            }

            $freeShipping = $totalPrice > (1000 / $currencyRateEUR) && $totalPrice < (2500 / $currencyRateEUR);
            $minimumAmount = 500 / $currencyRateEUR;
            $belowMinimumAmount = $totalPrice < $minimumAmount;
        } else {
            if ($totalPrice > 2500 && $totalPrice <= 5000) {
                $discount = $totalPrice * 0.10;
                $totalDiscountPrice -= $discount;
            }

            $freeShipping = $totalPrice > 1000 && $totalPrice < 2500;
            $minimumAmount = 500;
            $belowMinimumAmount = $totalPrice < $minimumAmount;
        }

        $paymentMethods = PaymentMethod::all();

        return view('site.orders.create', compact('cartItems', 'totalPrice', 'totalDiscountPrice', 'discount', 'freeShipping', 'belowMinimumAmount', 'minimumAmount', 'paymentMethods'));
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
