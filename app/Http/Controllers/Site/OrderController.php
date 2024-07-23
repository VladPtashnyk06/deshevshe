<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\UpdateOneOrderRequest;
use App\Mail\OrderMail;
use App\Models\Delivery;
use App\Models\MeestRegion;
use App\Models\NovaPoshtaRegion;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\UkrPoshtaRegion;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserPromocode;
use App\Services\MeestService;
use App\Services\NovaPoshtaService;
use App\Services\UkrPoshtaService;
use Darryldecode\Cart\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use const http\Client\Curl\AUTH_ANY;

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
        $novaPoshtaRegions = NovaPoshtaRegion::all();
        $meestRegions = MeestRegion::all();
        $ukrPoshtaRegions = UkrPoshtaRegion::all();

        $delivery = null;
        if (\Auth::user() && \Auth::user()->role == 'user') {
            $delivery = \Auth::user()->userAddress()->first();
        }

        return view('site.orders.create', compact('cartItems', 'totalPrice', 'totalDiscountPrice', 'discount', 'freeShipping', 'belowMinimumAmount', 'minimumAmount', 'paymentMethods', 'novaPoshtaRegions', 'meestRegions', 'ukrPoshtaRegions', 'delivery'));
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
                    'middle_name' => $request->validated('user_middle_name'),
                    'password' => \Hash::make($request->validated('password')),
                ]);
            }
        }

        if ($request->validated('promo_code')) {
            $promoCode = PromoCode::where('title', $request->validated('promo_code'))->first();
            if ($promoCode) {
                if ($userPromoCode = UserPromocode::where('user_id', $request->validated('user_id'))->where('promo_code_id', $promoCode->id)->first()) {
                    if ($userPromoCode->status == 'Не використанний') {
                        if ($promoCode->quantity_now < $promoCode->quantity) {
                            $promoCodeId = $promoCode->id;
                            $phoneOrders = Order::where('user_phone', $request->validated('user_phone'))->get();
                            $promoCodeUsed = false;
                            foreach ($phoneOrders as $phoneOrder) {
                                if ($phoneOrder->promo_code_id == $promoCodeId) {
                                    $promoCodeUsed = true;
                                    return back()->withErrors(['promo_code' => 'Ви вже використали цей промокод']);
                                }
                            }
                            if ($promoCodeUsed == false) {
                                $totalPrice = $request->validated('total_price') - ($request->validated('total_price') * ($promoCode->rate / 100));
                                $promoCode->update([
                                    'quantity_now' => $promoCode->quantity_now + 1
                                ]);
                                $userPromoCode->update([
                                    'status' => 'Використанний'
                                ]);
                                $promoCodeId = $promoCode->id;
                            }
                        } else {
                            return back()->withErrors(['promo_code' => 'Цей промокод не доступний']);
                        }
                    } else {
                        return back()->withErrors(['promo_code' => 'Ви вже використали цей промокод']);
                    }
                }
                else {
                    return back()->withErrors(['promo_code' => 'Такого промокоду немає']);
                }
            } else {
                return back()->withErrors(['promo_code' => 'Такого промокоду немає']);
            }
        }

        if ($request->validated('points')) {
            if (isset($totalPrice)) {
                $totalPrice = $totalPrice - $request->validated('points');
            } else {
                $totalPrice = $request->validated('total_price') - $request->validated('points');
            }
            $user = User::find($request->validated('user_id'));
            $user->update([
                'points' => $user->points - $request->validated('points'),
            ]);
        }

        $orderStatus = OrderStatus::where('title', 'Нове')->first();
        if (isset($newUser)) {
            $newOrder = Order::create([
                'user_id' => $newUser->id,
                'order_status_id' => $orderStatus->id,
                'payment_method_id' => $request->validated('payment_method_id'),
                'promo_code_id' => isset($promoCodeId) ? $promoCodeId : null,
                'cost_delivery' => $request->validated('cost_delivery'),
                'user_name' => $request->validated('user_name'),
                'user_last_name' => $request->validated('user_last_name'),
                'user_middle_name' => $request->validated('user_middle_name'),
                'user_phone' => $request->validated('user_phone'),
                'user_email' => $request->validated('user_email') ? $request->validated('user_email') : null,
                'total_price' => isset($totalPrice) ? $totalPrice : $request->validated('total_price'),
                'currency' => $request->validated('currency'),
                'comment' => $request->validated('comment'),
            ]);
        } else {
            $newOrder = Order::create([
                'user_id' => !empty($request->validated('user_id')) ? $request->validated('user_id') : null,
                'order_status_id' => 1,
                'payment_method_id' => $request->validated('payment_method_id'),
                'promo_code_id' => isset($promoCodeId) ? $promoCodeId : null,
                'cost_delivery' => $request->validated('cost_delivery'),
                'user_name' => $request->validated('user_name'),
                'user_last_name' => $request->validated('user_last_name'),
                'user_middle_name' => $request->validated('user_middle_name'),
                'user_phone' => $request->validated('user_phone'),
                'user_email' => $request->validated('user_email') ? $request->validated('user_email') : null,
                'total_price' => isset($totalPrice) ? $totalPrice : $request->validated('total_price'),
                'currency' => $request->validated('currency'),
                'comment' => $request->validated('comment'),
            ]);
        }
        if (isset($newOrder)) {
            session()->put('points_'.$newOrder->id , $request->validated('points'));
            $cartItems = \Cart::getContent()->sortBy('id');
            foreach ($cartItems as $item) {
                $product = Product::find($item->attributes->product_id);
                OrderDetail::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $item->attributes->product_id,
                    'color_id' => $item->attributes->color_id,
                    'size_id' => $item->attributes->size_id,
                    'color' => $item->attributes->color,
                    'size' => $item->attributes->size,
                    'product_total_price' => $product->price->retail * $item->quantity,
                    'quantity_product' => $item->quantity
                ]);
            }
            $deliveryNameAndType = $request->validated('delivery_type');
            list($deliveryName, $deliveryType) = explode('_', $deliveryNameAndType, 2);
            $settlementType = null;
            $settlement = null;
            if ($request->validated('nova_poshta_city_input') || $request->validated('meest_city_input') || $request->validated('ukr_poshta_city_input')) {
                $settlementType = 'місто';
            } elseif ($request->validated('village_input')) {
                $village = $request->validated('village_input');

                preg_match('/(с\.|село|смт|селище міського типу)\s+(.+)/ui', $village, $matches);

                if (!empty($matches)) {
                    $settlementType = $matches[1];
                    $settlement = $matches[2];
                }
            }
            if ($deliveryName == 'NovaPoshta') {
                Delivery::create([
                    'order_id' => $newOrder->id,
                    'delivery_name' => $deliveryName,
                    'delivery_method' => $deliveryType,
                    'region' => $request->validated('region'),
                    'regionRef' => $request->validated('nova_poshta_region_ref'),
                    'settlementType' => $settlementType,
                    'settlement' => $request->validated('nova_poshta_city_input') ?? $settlement,
                    'settlementRef' => $request->validated('city_ref') ?? $request->validated('village_ref'),
                    'branch' => $request->validated('nova_poshta_branches_input'),
                    'branchNumber' => $request->validated('branch_number'),
                    'branchRef' => $request->validated('branch_ref'),
                    'district' => $request->validated('district_input'),
                    'districtRef' => $request->validated('district_ref'),
                    'street' => $request->validated('street_input'),
                    'streetRef' => $request->validated('street_ref'),
                    'house' => $request->validated('house'),
                    'flat' => $request->validated('flat'),
                ]);
            } elseif ($deliveryName == 'Meest') {
                Delivery::create([
                    'order_id' => $newOrder->id,
                    'delivery_name' => $deliveryName,
                    'delivery_method' => $deliveryType,
                    'region' => $request->validated('region'),
                    'regionRef' => $request->validated('meest_region_ref'),
                    'settlementType' => $settlementType,
                    'settlement' => $request->validated('meest_city_input') ?? $settlement,
                    'settlementRef' => $request->validated('city_ref') ?? $request->validated('village_ref'),
                    'branch' => $request->validated('meest_branches_input'),
                    'branchNumber' => '',
                    'branchRef' => $request->validated('branch_ref'),
                    'district' => $request->validated('district_input'),
                    'districtRef' => $request->validated('district_ref'),
                    'street' => $request->validated('street_input'),
                    'streetRef' => $request->validated('street_ref'),
                    'house' => $request->validated('house'),
                    'flat' => $request->validated('flat'),
                ]);
            } else if ($deliveryName == 'UkrPoshta') {
                Delivery::create([
                    'order_id' => $newOrder->id,
                    'delivery_name' => $deliveryName,
                    'delivery_method' => $deliveryType,
                    'region' => $request->validated('region'),
                    'regionRef' => $request->validated('ukr_poshta_region_ref'),
                    'settlementType' => $settlementType,
                    'settlement' => $request->validated('ukr_poshta_city_input') ?? $settlement,
                    'settlementRef' => $request->validated('city_ref') ?? $request->validated('village_ref'),
                    'branch' => $request->validated('ukr_poshta_branches_input'),
                    'branchNumber' => '',
                    'branchRef' => $request->validated('branch_ref'),
                    'district' => $request->validated('district_input'),
                    'districtRef' => $request->validated('district_ref'),
                    'street' => $request->validated('street_input'),
                    'streetRef' => $request->validated('street_ref'),
                    'house' => $request->validated('house'),
                    'flat' => $request->validated('flat'),
                ]);
            }
//            Mail::to('zembitskijdenis813@gmail.com')->send(new OrderMail($newOrder));
            Mail::to('vlad1990pb@gmail.com')->send(new OrderMail($newOrder));

            if ($newOrder->user_id) {
                UserAddress::updateOrCreate(
                    [
                        'user_id' => $newOrder->user_id,
                    ],
                    [
                        'delivery_name' => $newOrder->delivery->delivery_name,
                        'delivery_method' => $newOrder->delivery->delivery_method,
                        'region' => $newOrder->delivery->region,
                        'regionRef' => $newOrder->delivery->regionRef,
                        'settlementType' => $newOrder->delivery->settlementType,
                        'settlement' => $newOrder->delivery->settlement ?? null,
                        'settlementRef' => $newOrder->delivery->settlementRef ?? null,
                        'branch' => $newOrder->delivery->branch ?? null,
                        'branchRef' => $newOrder->delivery->branchRef ?? null,
                        'district' => $newOrder->delivery->district ?? null,
                        'districtRef' => $newOrder->delivery->districtRef ?? null,
                        'street' => $newOrder->delivery->street ?? null,
                        'streetRef' => $newOrder->delivery->streetRef ?? null,
                        'house' => $newOrder->delivery->house ?? null,
                        'flat' => $newOrder->delivery->flat ?? null,
                    ]
                );
            }

//            Cart::clear();
        }

        return redirect()->route('site.order.thankYou');
    }

    public function jsonFile()
    {
        $json = UserAddress::all();

        return response()->json($json);
    }

    public function updateCart(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id' => 'required|string|max:12',
            'quantity' => 'required|integer|max:1024',
        ]);

        if ($request->has('quantityDed') && ($validated['quantity'] > 1)) {
            \Cart::update(
                $validated['id'],
                [
                    'quantity' => [
                        'relative' => false,
                        'value' => $validated['quantity'] - 1,
                    ],
                ]
            );
        }

        if ($request->has('quantityAdd')) {
            \Cart::update(
                $validated['id'],
                [
                    'quantity' => [
                        'relative' => false,
                        'value' => $validated['quantity'] + 1,
                    ],
                ]
            );
        }

        return back()->with('cart', 'cart_updated');
    }

    public function thankYou()
    {
        return view('site.orders.thank-you');
    }

    public function oneOrder(Order $order)
    {
        $paymentMethods = PaymentMethod::all();
        $novaPoshtaService = new NovaPoshtaService();
        $novaPoshtaRegions = $novaPoshtaService->getRegions();

        $meestService = new MeestService();
        $meestRegions = $meestService->getRegions();

        $ukrPoshtaService = new UkrPoshtaService();
        $ukrPoshtaRegions = $ukrPoshtaService->getRegions();

        $deliveryNameAndType = $order->delivery->delivery_name.'_'.$order->delivery->delivery_method;
        return view('site.orders.one-order', compact('order', 'paymentMethods', 'novaPoshtaRegions', 'meestRegions', 'ukrPoshtaRegions', 'deliveryNameAndType'));
    }

    public function updateOneOrder(UpdateOneOrderRequest $request, Order $order)
    {
        $order->update($request->validated());

        $delivery = Delivery::where('order_id', $order->id)->first();
        $deliveryNameAndType = $request->validated('delivery_type');
        list($deliveryName, $deliveryType) = explode('_', $deliveryNameAndType, 2);
        if ($deliveryName == 'NovaPoshta') {
            $delivery->update([
                'delivery_name' => $deliveryName,
                'delivery_method' => $deliveryType,
                'region' => $request->validated('NovaPoshtaRegion'),
                'city' => $request->validated('NovaPoshtaCityInput'),
                'cityRef' => $request->validated('cityRefHidden'),
                'branch' => $request->validated('NovaPoshtaBranchesInput'),
                'branchRef' => $request->validated('branchRefHidden'),
                'address' => $request->validated('address'),
            ]);
        } elseif ($deliveryName == 'Meest') {
            $delivery->update([
                'delivery_name' => $deliveryName,
                'delivery_method' => $deliveryType,
                'region' => $request->validated('MeestRegion'),
                'city' => $request->validated('MeestCityInput'),
                'cityRef' => $request->validated('meestCityIDHidden'),
                'branch' => $request->validated('MeestBranchesInpute'),
                'branchRef' => $request->validated('meestBranchIDHidden'),
                'address' => $request->validated('address'),
            ]);
        } else if ($deliveryName == 'UkrPoshta') {
            $delivery->update([
                'delivery_name' => $deliveryName,
                'delivery_method' => $deliveryType,
                'region' => $request->validated('UkrPoshtaRegion'),
                'city' => $request->validated('UkrPoshtaCityInput'),
                'cityRef' => $request->validated('ukrPoshtaCityIdHidden'),
                'branch' => $request->validated('UkrPoshtaBranchesInput'),
                'branchRef' => $request->validated('ukrPoshtaBranchIDHidden'),
                'address' => $request->validated('address'),
            ]);
        }

        return redirect()->route('site.order.thankYou');
    }
}
