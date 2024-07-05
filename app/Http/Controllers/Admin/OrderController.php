<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\UkrPoshtaController;
use App\Http\Requests\OrderEditFirstRequest;
use App\Http\Requests\OrderEditFourthRequest;
use App\Http\Requests\OrderEditSecondRequest;
use App\Http\Requests\OrderEditThirdRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\OrderSmallRequest;
use App\Mail\OrderClientMail;
use App\Mail\OrderMail;
use App\Models\Delivery;
use App\Models\MeestRegion;
use App\Models\NovaPoshtaRegion;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\PromoCode;
use App\Models\UkrPoshtaRegion;
use App\Models\User;
use App\Services\MeestService;
use App\Services\NovaPoshtaService;
use App\Services\UkrPoshtaService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Notifications\OrderStatusUpdate;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $queryParams = $request->only(['id', 'name_and_last_name', 'phone', 'email', 'status', 'created_at', 'updated_at', 'operator']);
        $filteredParams = array_filter($queryParams);
        $query = Order::query();

        if (isset($filteredParams['id'])) {
            $query->where('id', 'LIKE', '%' . $filteredParams['id'] . '%');
        }

        if (isset($filteredParams['name_and_last_name'])) {
            $query->orWhere('user_name', 'LIKE', '%' . $filteredParams['name_and_last_name'] . '%')->orWhere('user_last_name', 'LIKE', '%' . $filteredParams['name_and_last_name'] . '%');
        }

        if (isset($filteredParams['phone'])) {
            $query->where('user_phone', 'LIKE', '%' . $filteredParams['phone'] . '%');
        }

        if (isset($filteredParams['email'])) {
            $query->where('user_email', 'LIKE', '%' . $filteredParams['email'] . '%');
        }

        if (isset($filteredParams['status'])) {
            $query->where('order_status_id', $filteredParams['status']);
        }

        if (isset($filteredParams['created_at'])) {
            $query->whereDate('orders.created_at', $filteredParams['created_at']);
        }

        if (isset($filteredParams['updated_at'])) {
            $query->whereDate('orders.updated_at', $filteredParams['updated_at']);
        }

        if (isset($filteredParams['operator'])) {
            $query->where('operator_id', $filteredParams['operator']);
        }

        $orders = $query->orderBy('orders.created_at', 'desc')->get();
        $orderStatuses = OrderStatus::all();
        $operators = User::where('role', 'operator')->get();

        return view('admin.orders.index', compact('orders', 'orderStatuses', 'operators'));
    }

    public function updateStatusAndOperator(Request $request, $orderId)
    {
        $request->validate([
            'status_id' => 'required',
            'operator_id' => 'required',
        ]);

        $order = Order::findOrFail($orderId);

        $order->update([
            'order_status_id' => $request->status_id,
            'operator_id' => $request->operator_id,
        ]);

        if ($order->orderStatus->title === 'Пакують') {
            $this->handlePackingStatus($order);


            foreach ($order->orderDetails()->get() as $orderDetail) {
                $product = Product::find($orderDetail->product_id);
                foreach ($product->productVariants as $productVariant) {
                    if ($productVariant->color->title === $orderDetail->color && $productVariant->size->title === $orderDetail->size) {
                        $productVariant->update([
                            'quantity' => $productVariant->quantity - $orderDetail->quantity_product
                        ]);
                    }
                }
            }
        } elseif (in_array($order->orderStatus->title, ['Не відповідає', 'Повернення', 'Скасоване клієнтом'])) {
            foreach ($order->orderDetails()->get() as $orderDetail) {
                $product = Product::find($orderDetail->product_id);
                foreach ($product->productVariants as $productVariant) {
                    if ($productVariant->color->title === $orderDetail->color && $productVariant->size->title === $orderDetail->size) {
                        $productVariant->update([
                            'quantity' => $productVariant->quantity + $orderDetail->quantity_product
                        ]);
                    }
                }
            }
        }

        if ($order->orderStatus->title === 'Відравлено') {
            Mail::to('vlad1990pb@gmail.com')->send(new OrderClientMail($order));

            $orders = Order::whereDate('created_at', Carbon::today())
                ->where('order_status_id', $order->order_status_id)
                ->get();

            foreach ($orders as $order) {
                if ($order->int_doc_number) {
                    $userPhone = str_replace('+', '', $order->user_phone);
                    $message = "Ваше замовлення було відправлено. Ваша ТТН: {$order->int_doc_number}. Дякуємо Вам за замовлення.";

//                    File::put(storage_path('logs/laravel.log'), '');
//                    if ($userPhone) {
//                        \Log::info("Відправлене SMS до {$userPhone} з повідомленям: {$message}");
//                        $order->notify(new OrderStatusUpdate($message));
//                    }
                }
            }
        }

        return response()->json(['message' => 'Order status and operator updated successfully'], 200);
    }

    public function addTTNtoOrder(Order $order)
    {
        return view('admin.orders.add-ttn', compact('order'));
    }

    public function updateTTNtoOrder(Order $order, Request $request)
    {
        $order->update([
            'int_doc_number' => $request->input('ttn'),
        ]);
        return redirect()->route('operator.order.index');
    }

    protected function handlePackingStatus($order)
    {
        $filePath = storage_path('app/orders/orders.json');

        if (Storage::disk('local')->exists('orders/orders.json')) {
            $fileContent = Storage::disk('local')->get('orders/orders.json');
            if (empty($fileContent)) {
                $ordersData = [];
            } else {
                $ordersData = json_decode($fileContent, true);
            }
        } else {
            $ordersData = [];
        }

        $orderData = $this->formatOrderData($order);

        $existingOrderKey = null;
        foreach ($ordersData as $key => $existingOrder) {
            if ($existingOrder['order']['id'] == $order->id) {
                $existingOrderKey = $key;
                break;
            }
        }

        if ($existingOrderKey !== null) {
            $ordersData[$existingOrderKey] = $orderData;
        } else {
            $ordersData[] = $orderData;
        }

        Storage::disk('local')->put('orders/orders.json', json_encode($ordersData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

//    $this->sendOrderDataTo1C($filePath, $ordersData);
    }


    protected function formatOrderData(Order $order)
    {
        if ($order->delivery->delivery_name == 'UkrPoshta') {
            $branch = $order->delivery->branch;

            preg_match('/(\d{5})\s*(.*?)[,\s]+(.*?)\s*([0-9\/]*)$/', $branch, $matches);

            if (!empty($matches)) {
                $postal_code = $matches[1];
            } else {
                $postal_code = null;
            }
        }

        return [
            'order' => [
                'id' => $order->id,
                'user_id' => $order->user_id ? $order->user_id : null,
                'order_status' => $order->orderStatus->title,
                'payment_method' => $order->paymentMethod->title,
                'user_name' => $order->user_name,
                'user_last_name' => $order->user_last_name,
                'user_middle_name' => $order->user_middle_name,
                'user_phone' => $order->user_phone,
                'user_email' => $order->user_email,
                'cost_delivery' => $order->cost_delivery,
                'total_price' => $order->total_price,
                'currency' => $order->currency,
                'comment' => $order->comment ?? null,
                'created_at' => $order->created_at
            ],
            'details' => $order->orderDetails->map(function($orderDetail) {
                return [
                    'product_code' => $orderDetail->product->code,
                    'color_id' => $orderDetail->color_id,
                    'color' => $orderDetail->color,
                    'size_id' => $orderDetail->size_id,
                    'size' => $orderDetail->size,
                    'quantity' => $orderDetail->quantity_product,
                    'product_total_price' => $orderDetail->product_total_price,
                ];
            })->toArray(),
            'delivery' => [
                'delivery_name' => $order->delivery->delivery_name == 'NovaPoshta' ? 'Нова Пошта' : ($order->delivery->delivery_name == 'Meest' ? 'Meest' : ($order->delivery->delivery_name == 'UkrPoshta' ? 'Укр Пошта' : '')),
                'delivery_method' => $order->delivery->delivery_method == 'branch' ? 'Відділення' : ($order->delivery->delivery_method == 'exspresBranch' ? 'Експрес відділення' : ($order->delivery->delivery_method == 'postomat' ? 'Поштомат' : ($order->delivery->delivery_method == 'courier' ? 'Кур`єр' : ($order->delivery->delivery_method == 'exspresCourier' ? 'Експрес кур`єр' : '')))),
                'region' => $order->delivery->region,
                'regionRef' => $order->delivery->regionRef,
                'settlementType' => $order->delivery->settlementType,
                'settlement' => $order->delivery->settlement,
                'settlementRef' => $order->delivery->settlementRef,
                'branch' => $order->delivery->branch,
                'branchNumber' => $order->delivery->delivery_name == 'UkrPoshta' ? $postal_code : $order->delivery->branchNumber,
                'branchRef' => $order->delivery->branchRef,
                'district' => $order->delivery->district,
                'districtRef' => $order->delivery->districtRef,
                'street' => $order->delivery->street,
                'streetRef' => $order->delivery->streetRef,
                'house' => $order->delivery->house,
                'flat' => $order->delivery->flat,
            ]
        ];
    }

//    protected function sendOrderDataTo1C($fileName, $orderData)
//    {
//        $url = 'https://app.super-price.test/api/1c/orders';
//
//        Http::post($url, [
//            'file_name' => $fileName,
//            'order_data' => $orderData,
//        ]);
//    }

    /**
     * @param Order $order
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function editFirst(Order $order)
    {
       return view('admin.orders.edit_first', compact('order'));
    }

    /**
     * @param OrderEditFirstRequest $request
     * @param Order $order
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function updateFirst(OrderEditFirstRequest $request, Order $order)
    {
        $currency_rate_usd = session()->get('currency_rate_usd');
        $currency_rate_eur = session()->get('currency_rate_eur');
        if ($request->validated('currency') == 'UAH' && $order->currency == 'USD') {
            $order->update([
                'total_price' => $order->total_price * $currency_rate_usd,
            ]);
        } elseif ($request->validated('currency') == 'UAH' && $order->currency == 'EUR') {
            $order->update([
                'total_price' => $order->total_price * $currency_rate_eur,
            ]);
        } elseif ($request->validated('currency') == 'USD' && $order->currency == 'UAH') {
            $order->update([
                'total_price' => $order->total_price / $currency_rate_usd,
            ]);
        } elseif ($request->validated('currency') == 'USD' && $order->currency == 'EUR') {
            $order->update([
                'total_price' => ( $order->total_price * $currency_rate_eur ) / $currency_rate_usd,
            ]);
        } elseif ($request->validated('currency') == 'EUR' && $order->currency == 'UAH') {
            $order->update([
                'total_price' => $order->total_price / $currency_rate_eur,
            ]);
        } elseif ($request->validated('currency') == 'EUR' && $order->currency == 'USD') {
            $order->update([
                'total_price' => ( $order->total_price * $currency_rate_usd ) / $currency_rate_eur,
            ]);
        }
        $order->update([
            'user_name' => $request->validated('user_name'),
            'user_last_name' => $request->validated('user_last_name'),
            'user_phone' => $request->validated('user_phone'),
            'user_email' => $request->validated('user_email'),
            'currency' => $request->validated('currency')
        ]);

        return redirect()->route('operator.order.editSecond', $order->id);
    }

    /**
     * @param Order $order
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function editSecond(Order $order)
    {
        return view('admin.orders.edit_second', compact('order'));
    }

    public function updateSecond(OrderEditSecondRequest $request, Order $order)
    {
        if ($request->validated('product')) {
            foreach ($request->validated('product') as $orderDetailId => $quantity) {
                $orderDetail = OrderDetail::find($orderDetailId);
                $product = Product::find($orderDetail->product_id);
                $orderDetail->update([
                    'product_total_price' => $product->price->retail *  $quantity['quantity_product'],
                    'quantity_product' => $quantity['quantity_product']
                ]);
            }
        }

        $totalPrice = 0;
        $allOrderDetails = OrderDetail::where('order_id', $order->id)->get();
        foreach ($allOrderDetails as $orderDetail) {
            $totalPrice += $orderDetail->product_total_price;
        }

        if ($totalPrice > 2500 && $totalPrice < 5000) {
            $totalPrice *= 0.9;
        }

        if ($totalPrice < 2500 && $totalPrice > 500) {
            $delivery = 'Безкоштовно';
        } else {
            $delivery = 'За Ваш рахунок';
        }

        $order->update([
            'total_price' => $totalPrice,
            'cost_delivery' => $delivery
        ]);

        if ($request->validated('additionalProduct')) {
            foreach ($request->validated('additionalProduct') as $additionalProduct) {
                $productVariant = ProductVariant::find($additionalProduct['product_variant_id']);
                $product = Product::find($productVariant->product_id);

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $productVariant->product_id,
                    'color_id' => $productVariant->color_id,
                    'size_id' => $productVariant->size_id,
                    'color' => $productVariant->color->title,
                    'size' => $productVariant->size->title,
                    'product_total_price' => $product->price->retail * $additionalProduct['quantity'],
                    'quantity_product' => $additionalProduct['quantity']
                ]);
            }
        }

        return redirect()->route('operator.order.editThird', $order->id);
    }

    public function editThird(Order $order)
    {
        $novaPoshtaRegions = NovaPoshtaRegion::all();

        $meestRegions = MeestRegion::all();

        $ukrPoshtaRegions = UkrPoshtaRegion::all();

        $deliveryNameAndType = $order->delivery->delivery_name.'_'.$order->delivery->delivery_method;
        if ($order->delivery->district) {
            $deliveryLocation = 'Village';
        } else {
            $deliveryLocation = 'City';
        }
        return view('admin.orders.edit_third', compact('order', 'novaPoshtaRegions', 'meestRegions', 'deliveryNameAndType', 'ukrPoshtaRegions', 'deliveryLocation'));
    }

    public function updateThird(OrderEditThirdRequest $request, Order $order)
    {
        $order->update($request->validated());

        $delivery = Delivery::where('order_id', $order->id)->first();
        $deliveryNameAndType = $request->validated('delivery_type');
        list($deliveryName, $deliveryType) = explode('_', $deliveryNameAndType, 2);
        $settlementType = null;
        $settlement = null;
        if ($request->validated('city_name')) {
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
            $delivery->update([
                'delivery_name' => $deliveryName,
                'delivery_method' => $deliveryType,
                'region' => $request->validated('region'),
                'regionRef' => $request->validated('nova_poshta_region_ref'),
                'settlementType' => $settlementType,
                'settlement' => $request->validated('city_name') ?? $settlement,
                'settlementRef' => $request->validated('city_ref') ?? $request->validated('village_ref'),
                'branch' => $request->validated('branch_name'),
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
            $delivery->update([
                'delivery_name' => $deliveryName,
                'delivery_method' => $deliveryType,
                'region' => $request->validated('region'),
                'regionRef' => $request->validated('meest_region_ref'),
                'settlementType' => $settlementType,
                'settlement' => $request->validated('city_name') ?? $settlement,
                'settlementRef' => $request->validated('city_ref') ?? $request->validated('village_ref'),
                'branch' => $request->validated('branch_name'),
                'branchNumber' => $request->validated('branch_number'),
                'branchRef' => $request->validated('branch_ref'),
                'district' => $request->validated('district_input'),
                'districtRef' => $request->validated('district_ref'),
                'village' => $request->validated('village_input'),
                'villageRef' => $request->validated('village_ref'),
                'street' => $request->validated('street_input'),
                'streetRef' => $request->validated('street_ref'),
                'house' => $request->validated('house'),
                'flat' => $request->validated('flat'),
            ]);
        } else if ($deliveryName == 'UkrPoshta') {
            $delivery->update([
                'delivery_name' => $deliveryName,
                'delivery_method' => $deliveryType,
                'region' => $request->validated('region'),
                'regionRef' => $request->validated('ukr_poshta_region_ref'),
                'settlementType' => $settlementType,
                'settlement' => $request->validated('city_name') ?? $settlement,
                'settlementRef' => $request->validated('city_ref') ?? $request->validated('village_ref'),
                'branch' => $request->validated('branch_name'),
                'branchNumber' => $request->validated('branch_number'),
                'branchRef' => $request->validated('branch_ref'),
                'district' => $request->validated('district_input'),
                'districtRef' => $request->validated('district_ref'),
                'village' => $request->validated('village_input'),
                'villageRef' => $request->validated('village_ref'),
                'street' => $request->validated('street_input'),
                'streetRef' => $request->validated('street_ref'),
                'house' => $request->validated('house'),
                'flat' => $request->validated('flat'),
            ]);
        }
        return redirect()->route('operator.order.editFourth', $order->id);
    }

    public function editFourth(Order $order)
    {
        $paymentMethods = PaymentMethod::all();
        $statuses = OrderStatus::all();
        return view('admin.orders.edit_fourth', compact('order', 'paymentMethods', 'statuses'));
    }

    public function updateFourth(OrderEditFourthRequest $request, Order $order)
    {
        $order->update($request->validated());

        if ($order->orderStatus->title == 'Пакують') {
            foreach ($order->orderDetails()->get() as $orderDetail) {
                $product = Product::find($orderDetail->product_id);
                foreach ($product->productVariants as $productVariant) {
                    if ($productVariant->color->title == $orderDetail->color && $productVariant->size->title == $orderDetail->size) {
                        $productVariant->update([
                            'quantity' => $productVariant->quantity - $orderDetail->quantity_product
                        ]);
                    }
                }
            }
        } elseif ($order->orderStatus->title == 'Не відповідає' || $order->orderStatus->title == 'Повернення' || $order->orderStatus->title == 'Скасоване клієнтом') {
            foreach ($order->orderDetails()->get() as $orderDetail) {
                $product = Product::find($orderDetail->product_id);
                foreach ($product->productVariants as $productVariant) {
                    if ($productVariant->color->title == $orderDetail->color && $productVariant->size->title == $orderDetail->size) {
                        $productVariant->update([
                            'quantity' => $productVariant->quantity + $orderDetail->quantity_product
                        ]);
                    }
                }
            }
        }

        return redirect()->route('operator.order.index');
    }

    public function updateOrderPromoCode(Request $request, Order $order)
    {
        if ($request->post('promo_code')) {
            $promoCode = PromoCode::where('title', $request->post('promo_code'))->first();
            if ($promoCode) {
                if ($promoCode->quantity_now < $promoCode->quantity) {
                    $promoCodeId = $promoCode->id;
                    $phoneOrders = Order::where('user_phone', $order->user_phone)->get();
                    $promoCodeUsed = false;
                    foreach ($phoneOrders as $phoneOrder) {
                        if ($phoneOrder->promo_code_id == $promoCodeId) {
                            $promoCodeUsed = true;
                            return back()->withErrors(['promo_code' => 'Цей користувач використовував цей промокод']);
                        }
                    }
                    if ($promoCodeUsed == false) {
                        $totalPrice = $order->total_price - ($order->total_price * ($promoCode->rate / 100));
                        $promoCode->update([
                            'quantity_now' => $promoCode->quantity_now + 1
                        ]);
                        $promoCodeId = $promoCode->id;
                        $order->update([
                            'promo_code_id' => $promoCodeId,
                            'total_price' => $totalPrice,
                        ]);
                    }
                } else {
                    return back()->withErrors(['promo_code' => 'Цей промокод не доступний, закінчився']);
                }
            } else {
                return back()->withErrors(['promo_code' => 'Такого промокоду немає']);
            }
        }
        return back();
    }

    public function updateOrderPoints(Request $request, Order $order)
    {
        if ($request->post('points')) {
            $order->update([
                'total_price' => $order->total_price - $request->post('points')
            ]);
            $order->user->update([
                'points' => $order->user->points - $request->post('points'),
            ]);
            session()->put('points_'.$order->id , $request->post('points'));
        }
        return back();
    }

    public function showUserOrders(Order $order)
    {
        if ($order->user_id) {
            $orders = Order::where('user_id', $order->user_id)
                ->orderBy('created_at', 'desc')
                ->get();
            $user = User::find($order->user_id);
            $ordersPhone = $order->user_phone;
        } else {
            $orders = Order::where('user_phone', $order->user_phone)
                ->orderBy('created_at', 'desc')
                ->get();
            $user = '';
            $ordersPhone = $order->user_phone;
        }

        $allUsers = User::all();
        return view('admin.orders.user-orders', compact('orders', 'allUsers', 'user', 'ordersPhone'));
    }

    public function smallEdit(Order $order)
    {
        $paymentMethods = PaymentMethod::all();
        $novaPoshtaRegions = NovaPoshtaRegion::all();
        $meestRegions = MeestRegion::all();
        $ukrPoshtaRegions = UkrPoshtaRegion::all();

        $deliveryNameAndType = $order->delivery->delivery_name.'_'.$order->delivery->delivery_method;
        if ($order->delivery->district) {
            $deliveryLocation = 'Village';
        } else {
            $deliveryLocation = 'City';
        }
        return view('admin.orders.small-edit', compact('order', 'paymentMethods', 'novaPoshtaRegions', 'meestRegions', 'ukrPoshtaRegions', 'deliveryNameAndType', 'deliveryLocation'));
    }

    public function smallUpdate(OrderSmallRequest $request ,Order $order)
    {
        $order->update($request->validated());

        $delivery = Delivery::where('order_id', $order->id)->first();
        $deliveryNameAndType = $request->validated('delivery_type');
        list($deliveryName, $deliveryType) = explode('_', $deliveryNameAndType, 2);
        $settlementType = null;
        $settlement = null;
        if ($request->validated('city_name')) {
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
            $delivery->update([
                'delivery_name' => $deliveryName,
                'delivery_method' => $deliveryType,
                'region' => $request->validated('region'),
                'regionRef' => $request->validated('nova_poshta_region_ref'),
                'settlementType' => $settlementType,
                'settlement' => $request->validated('city_name') ?? $settlement,
                'settlementRef' => $request->validated('city_ref') ?? $request->validated('village_ref'),
                'branch' => $request->validated('branch_name'),
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
            $delivery->update([
                'delivery_name' => $deliveryName,
                'delivery_method' => $deliveryType,
                'region' => $request->validated('region'),
                'regionRef' => $request->validated('meest_region_ref'),
                'settlementType' => $settlementType,
                'settlement' => $request->validated('city_name') ?? $settlement,
                'settlementRef' => $request->validated('city_ref') ?? $request->validated('village_ref'),
                'branch' => $request->validated('branch_name'),
                'branchNumber' => $request->validated('branch_number'),
                'branchRef' => $request->validated('branch_ref'),
                'district' => $request->validated('district_input'),
                'districtRef' => $request->validated('district_ref'),
                'street' => $request->validated('street_input'),
                'streetRef' => $request->validated('street_ref'),
                'house' => $request->validated('house'),
                'flat' => $request->validated('flat'),
            ]);
        } else if ($deliveryName == 'UkrPoshta') {
            $delivery->update([
                'delivery_name' => $deliveryName,
                'delivery_method' => $deliveryType,
                'region' => $request->validated('region'),
                'regionRef' => $request->validated('ukr_poshta_region_ref'),
                'settlementType' => $settlementType,
                'settlement' => $request->validated('city_name') ?? $settlement,
                'settlementRef' => $request->validated('city_ref') ?? $request->validated('village_ref'),
                'branch' => $request->validated('branch_name'),
                'branchNumber' => $request->validated('branch_number'),
                'branchRef' => $request->validated('branch_ref'),
                'district' => $request->validated('district_input'),
                'districtRef' => $request->validated('district_ref'),
                'street' => $request->validated('street_input'),
                'streetRef' => $request->validated('street_ref'),
                'house' => $request->validated('house'),
                'flat' => $request->validated('flat'),
            ]);
        }

        return redirect()->route('operator.order.index');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json();
    }

    public function orderDetailDestroy(OrderDetail $orderDetail)
    {
        $orderDetail->delete();
        return back();
    }

    public function getProductsByCode(Request $request)
    {
        $code = $request->query('code');

        $products = Product::where('code', 'like', '%' . $code . '%')
            ->with(['productVariants.color', 'productVariants.size'])
            ->get();

        return response()->json($products);
    }
}
