<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="w-full mx-auto py-12" style="max-width: 114rem">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @include('admin.orders.header')

                <form action="{{ route('operator.order.updateFourth', $order->id) }}" method="post">
                    @csrf

                    <table class="w-full mt-16 mb-5 border-collapse">
                        <thead>
                        <tr class="text-center border-b-2 border-gray-700">
                            <th class="p-2 text-sm">Товар</th>
                            <th class="p-2 text-sm">Колір</th>
                            <th class="p-2 text-sm">Розмір</th>
                            <th class="p-2 text-sm">Код</th>
                            <th class="p-2 text-sm">Кількість</th>
                            <th class="p-2 text-sm">Максимальна кількість</th>
                            <th class="py-2 text-sm">Ціна за одницю</th>
                            <th class="py-2 text-sm">Разом</th>
                            <th class="p-2 text-sm">Дії</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->orderDetails()->get() as $orderDetail)
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-4 py-2 break-words max-w-xs text-center align-middle">
                                    @foreach($orderDetail->product->getMedia($orderDetail->product->id) as $media)
                                        @if($media->getCustomProperty('main_image') === 1)
                                            <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-20 w-auto rounded-md object-cover mb-2 mx-auto">
                                        @endif
                                    @endforeach
                                    <div>{{ $orderDetail->product->title }}</div>
                                </td>
                                <td class="py-4 break-words max-w-xs">
                                    {{ $orderDetail->color }}
                                </td>
                                <td class="py-4 max-w-xs">
                                    {{ $orderDetail->size }}
                                </td>
                                <td>
                                    {{ $orderDetail->product->code }}
                                </td>
                                <td class="break-words max-w-xs">
                                    {{ $orderDetail->quantity_product }}
                                </td>
                                <td class="break-words max-w-xs">
                                    @foreach($orderDetail->product->productVariants()->get() as $productVariant)
                                        @if($productVariant->color->title == $orderDetail->color && $productVariant->size->title == $orderDetail->size)
                                            {{ $productVariant->quantity }}
                                        @endif
                                    @endforeach
                                </td>
                                <td class="break-words max-w-xs">
                                    {{ $orderDetail->product->price->pair }}
                                    {{ $order->currency }}
                                </td>
                                <td class="break-words max-w-60">
                                    {{ $orderDetail->product_total_price }}
                                    {{ $order->currency }}
                                </td>
                                <td class="break-words max-w-xs text-center">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">Видалити</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="flex justify-end text-xl">
                        @if($order->promoCode)
                            <h2 class="font-bold">Загальна сума з використаним промокодом ({{ $order->promoCode->title }}): {{ $order->total_price }} {{ $order->currency }}</h2>
                        @else
                            <h2 class="font-bold">Загальна сума: {{ $order->total_price }} {{ $order->currency }}</h2>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="payment_method_id" class="block text-gray-700">Спосіб оплати</label>
                        <select name="payment_method_id" id="payment_method_id" class="w-full border rounded px-3 py-2">
                            <option value="">Всі способи оплати</option>
                            @foreach($paymentMethods as $paymentMethod)
                                <option value="{{ $paymentMethod->id }}" {{ $order->payment_method_id == $paymentMethod->id ? 'selected' : '' }}>{{ $paymentMethod->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <div class="flex flex-row items-end space-x-4">
                            <div class="flex-1">
                                @if ($errors->has('promo_code'))
                                    <div class="alert alert-danger bg-red-500 text-white p-2 mb-2 rounded">
                                        {{ $errors->first('promo_code') }}
                                    </div>
                                @endif
                                <label for="promo_code" class="block mb-2 text-gray-700 font-medium">Промокод</label>
                                <input type="text" name="promo_code" id="promo_code" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $order->promoCode ? $order->promoCode->title . ' ( ' . $order->promoCode->rate . '% )' : '' }}">
                            </div>
                            <div class="flex-shrink-0">
                                <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border" onclick="addPromoCode(this, {{ $order->id }})">Застосувати</button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex flex-row items-end space-x-4">
                            <div class="flex-1">
                                <label for="points" class="block mb-2 text-gray-700">Бали</label>
                                <input type="number" min="0" max="{{ $order->user ? $order->user->points : '0'}}" name="points" id="points" class="w-full border rounded px-3 py-2" placeholder="{{$order->user ? ('Максимальна кількість балів для цього користувача - '. $order->user->points .' '. session()->get('currency')) : 'Користувач не зареєстрований' }}">
                            </div>
                            <div class="flex-shrink-0">
                                <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border" onclick="addPoints(this, {{ $order->id }})">Застосувати</button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="order_status_id" class="block text-gray-700">Статус замовлення</label>
                        <select name="order_status_id" id="order_status_id" class="w-full border rounded px-3 py-2">
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ $order->order_status_id == $status->id ? 'selected' : '' }}>{{ $status->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="comment" class="block text-gray-700">Коментар</label>
                        <textarea name="comment" id="comment" class="w-full border rounded px-3 py-2 h-32">{{ $order->comment }}</textarea>
                    </div>

                    <div class="mt-4 flex justify-between">
                        <a class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border" style="padding: 10px 41px" href="{{ route('operator.order.editThird', $order->id) }}">
                            Назад
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">
                            Продовжити
                        </button>
                    </div>
                </form>
                @if (isset($order))
                    <form action="{{ route('operator.order.updateOrderPromoCode', $order->id) }}" method="POST" id="promo_{{ $order->id }}">
                        @csrf
                    </form>
                    <form action="{{ route('operator.order.updateOrderPoints', $order->id) }}" method="POST" id="points_{{ $order->id }}">
                        @csrf
                    </form>
                @endif
            </div>
        </section>
    </main>
</x-app-layout>
<script>
    function addPromoCode(button, orderId) {
        let promoCodeInput = document.getElementById('promo_code');
        if (orderId) {
            let form_id = '#promo_' + orderId;
            let form = document.querySelector(form_id);

            let hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'promo_code';
            hiddenInput.value = promoCodeInput.value;

            form.appendChild(hiddenInput);

            form.submit();
        }
    }

    function addPoints(button, orderId) {
        let pointsInput = document.getElementById('points');
        if (orderId) {
            let form_id = '#points_' + orderId;
            let form = document.querySelector(form_id);

            let hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'points';
            hiddenInput.value = pointsInput.value;

            form.appendChild(hiddenInput);

            form.submit();
        }
    }
</script>
