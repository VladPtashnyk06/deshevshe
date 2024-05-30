<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
use App\Services\MeestService;
use App\Services\NovaPoshtaService;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('site.orders.all-my-orders', compact('orders'));
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
        $novaPoshtaService = new NovaPoshtaService();
        $novaPoshtaRegions = $novaPoshtaService->getRegions();

        $meestService = new MeestService();
        $meestRegions = $meestService->getRegions();

        return view('site.orders.create', compact('cartItems', 'totalPrice', 'totalDiscountPrice', 'discount', 'freeShipping', 'belowMinimumAmount', 'minimumAmount', 'paymentMethods', 'novaPoshtaRegions', 'meestRegions'));
    }

    public function store(OrderRequest $request)
    {
        if ($request->post('registration') == 'on') {
            if ($request->validated('password') == $request->validated('password_confirmation')) {
                $newUser = User::create([
                    'phone' => $request->validated('user_phone'),
                    'email' => $request->validated('user_email') ? $request->validated('user_email') : null,
                    'name' => $request->validated('user_name'),
                    'last_name' => $request->validated('user_last_name'),
                    'password' => \Hash::make($request->validated('password')),
                ]);
            }
        }
        $orderStatus = OrderStatus::where('title', 'Нове')->first();
        if (isset($newUser)) {
            $newOrder = Order::create([
                'user_id' => $newUser->id,
                'order_status_id' => $orderStatus->id,
                'payment_method_id' => $request->validated('payment_method_id'),
                'cost_delivery' => $request->validated('cost_delivery'),
                'user_name' => $request->validated('user_name'),
                'user_last_name' => $request->validated('user_last_name'),
                'user_phone' => $request->validated('user_phone'),
                'user_email' => $request->validated('user_email') ? $request->validated('user_email') : null,
                'total_price' => $request->validated('total_price'),
                'currency' => $request->validated('currency'),
                'comment' => $request->validated('comment')
            ]);
        } else {
            $newOrder = Order::create([
                'user_id' => !empty($request->validated('user_id')) ? $request->validated('user_id') : null,
                'order_status_id' => 1,
                'user_name' => $request->validated('user_name'),
                'user_last_name' => $request->validated('user_last_name'),
                'user_phone' => $request->validated('user_phone'),
                'user_email' => $request->validated('user_email') ? $request->validated('user_email') : null,
                'payment_method_id' => $request->validated('payment_method_id'),
                'cost_delivery' => $request->validated('cost_delivery'),
                'total_price' => $request->validated('total_price'),
                'currency' => $request->validated('currency'),
                'comment' => $request->validated('comment')
            ]);
        }
        if (isset($newOrder)) {
            $cartItems = \Cart::getContent()->sortBy('id');
            foreach ($cartItems as $item) {
                $product = Product::find($item->attributes->product_id);
                OrderDetail::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $item->attributes->product_id,
                    'color' => $item->attributes->color,
                    'size' => $item->attributes->size,
                    'product_total_price' => $product->price->pair * $item->quantity,
                    'quantity_product' => $item->quantity
                ]);
            }
            $deliveryNameAndType = $request->validated('delivery_type');
            list($deliveryName, $deliveryType) = explode('_', $deliveryNameAndType, 2);
            Delivery::create([
                'order_id' => $newOrder->id,
                'delivery_name' => $deliveryName,
                'delivery_method' => $deliveryType,
                'region' => $request->validated('region'),
                'city' => $request->validated('city'),
                'cityRef' => $request->validated('cityRefHidden'),
                'branch' => $request->validated('branch'),
                'branchRef' => $request->validated('branchRefHidden'),
                'address' => $request->validated('address'),
            ]);
        }

        return redirect()->route('site.product.index');
    }

    public function oneOrder(Order $order)
    {
        return view('site.orders.one-order', compact('order'));
    }
}
