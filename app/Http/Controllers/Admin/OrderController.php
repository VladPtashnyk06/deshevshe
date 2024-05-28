<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;
use App\Http\Requests\OrderEditFirstRequest;
use App\Http\Requests\OrderEditFourthRequest;
use App\Http\Requests\OrderEditSecondRequest;
use App\Http\Requests\OrderEditThirdRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\OrderSmallRequest;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use App\Services\NovaPoshtaService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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

    public function updateStatusAndOperator($orderId, Request $request)
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

        return response()->json(['message' => 'Order status and operator updated successfully'], 200);
    }

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
        foreach ($request->validated('product') as $orderDetailId => $quantity) {
            $orderDetail = OrderDetail::find($orderDetailId);
            $product = Product::find($orderDetail->product_id);
            $orderDetail->update([
                'product_total_price' => $product->price->pair *  $quantity['quantity_product'],
                'quantity_product' => $quantity['quantity_product']
            ]);
        }

        $allOrderDetails = OrderDetail::where('order_id', $order->id)->get();
        $totalPrice = 0;
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
                    'color' => $productVariant->color->title,
                    'size' => $productVariant->size->title,
                    'product_total_price' => $product->price->pair * $additionalProduct['quantity'],
                    'quantity_product' => $additionalProduct['quantity']
                ]);
            }
        }

        return redirect()->route('operator.order.editThird', $order->id);
    }

    public function editThird(Order $order)
    {
        $novaPoshtaService = new NovaPoshtaService();
        $regions = $novaPoshtaService->getRegions();
        return view('admin.orders.edit_third', compact('order', 'regions'));
    }

    public function updateThird(OrderEditThirdRequest $request, Order $order)
    {
        $order->update($request->validated());

        $delivery = Delivery::where('order_id', $order->id)->first();
        $delivery->update([
            'region' => $request->validated('region'),
            'city' => $request->validated('city'),
            'cityRef' => $request->validated('cityRefHidden'),
            'address' => $request->validated('address'),
        ]);
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

        $delivery = Delivery::where('order_id', $order->id)->first();
        $delivery->update([
            'branch' => $request->validated('branch'),
            'branchRef' => $request->validated('branchRefHidden'),
        ]);
        return redirect()->route('operator.order.index');
    }

    public function showUserOrders(User $user)
    {
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $allUsers = User::all();
        return view('admin.orders.user-orders', compact('user','orders', 'allUsers'));
    }

    public function smallEdit(Order $order)
    {
        $paymentMethods = PaymentMethod::all();
        $novaPoshtaService = new NovaPoshtaService();
        $regions = $novaPoshtaService->getRegions();
        return view('admin.orders.small-edit', compact('order', 'paymentMethods', 'regions'));
    }

    public function smallUpdate(OrderSmallRequest $request ,Order $order)
    {
        $order->update($request->validated());

        $delivery = Delivery::where('order_id', $order->id)->first();
        $delivery->update([
            'region' => $request->validated('region'),
            'city' => $request->validated('city'),
            'cityRef' => $request->validated('cityRefHidden'),
            'branch' => $request->validated('branch'),
            'branchRef' => $request->validated('branchRefHidden'),
            'address' => $request->validated('address'),
        ]);

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
