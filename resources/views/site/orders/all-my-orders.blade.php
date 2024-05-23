<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="max-w-7xl mx-auto py-12">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h1 class="text-3xl font-semibold mb-6 text-center" itemprop="name">Всі мої замовлення</h1>
                <ul class="divide-y divide-gray-200">
                    @foreach($orders as $order)
                        <li class="mb-6">
                            <div class="border rounded p-4 flex justify-between">
                                <div class="w-3/4">
                                    <h2 class="text-xl font-semibold mb-2">Замовлення №{{ $order->id }}</h2>
                                    <div>
                                        <ul class="list-disc pl-6">
                                            @php($i = 1)
                                            @foreach($order->orderDetails()->take(2)->get() as $orderDetail)
                                                <p class="mb-2"><span class="font-semibold">Товар {{ $i++ }}:</span> {{ $orderDetail->product->title }}</p>
                                                <li class="ml-4 flex">
                                                    <p class="w-1/4 mb-1 flex-grow-1">Код: {{ $orderDetail->product->code }}</p>
                                                    <p class="w-1/4 mb-1 flex-grow-1">Колір: {{ $orderDetail->color }}</p>
                                                    <p class="w-1/4 mb-1 flex-grow-1">Розмір: {{ $orderDetail->size }}</p>
                                                    <p class="w-1/4 mb-1 flex-grow-1">Кількість: {{ $orderDetail->quantity_product }}</p>
                                                </li>
                                            @endforeach
                                            @if ($order->orderDetails()->count() > 2)
                                                <p class="mt-4">Щоб побачити все замовлення, натисніть на кнопку "Деталі замовлення".</p>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="w-1/4 ml-6 text-right flex items-center">
                                    <div>
                                        <p><span class="font-semibold">Статус:</span> {{ $order->orderStatus->title }}</p>
                                        <p><span class="font-semibold">Загальна вартість замовлення:</span> {{ number_format($order->total_price, 2, '.', ' ') . ' ' . $order->currency }}</p>
                                         <form action="{{ route('site.order.oneOrder', $order->id) }}" method="GET">
                                             <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300 mt-4">Деталі замовлення</button>
                                         </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

            </div>
        </section>
    </main>
</x-app-layout>
