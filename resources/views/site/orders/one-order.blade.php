<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="max-w-7xl mx-auto py-12">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h1 class="text-3xl font-semibold mb-6 text-left" itemprop="name">Замовлення №{{ $order->id }}</h1>
                <div class="flex flex-col md:flex-row md:justify-between">
                    <div class="md:w-2/3">
                        @foreach($order->orderDetails()->get() as $orderDetail)
                            <div class="flex items-center mb-4 border-b p-6" style="padding-left: 0">
                                <div class="flex-shrink-0">
                                    @foreach($orderDetail->product->getMedia($orderDetail->product->id) as $media)
                                        @if($media->getCustomProperty('main_image') === 1)
                                            <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-40 w-auto rounded-md object-cover mb-4">
                                        @endif
                                    @endforeach
                                </div>
                                <div class="ml-4 flex-1">
                                    <h2 class="text-lg font-semibold">
                                            {{ $orderDetail->product->title }}
                                    </h2>
                                    <p class="text-gray-500">Код: {{ $orderDetail->product->code }}</p>
                                    <p class="text-gray-500">Колір: {{ $orderDetail->color }}</p>
                                    <p class="text-gray-500">Розмір: {{ $orderDetail->size }}</p>
                                </div>
                                <div class="ml-4 flex items-center space-x-2">
                                    Кількість заказаного товару: <p class="px-2">{{ $orderDetail->quantity_product }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="md:w-1/3 bg-gray-100 p-6 rounded-lg shadow-lg mt-6 md:mt-0">
                        <h2 class="text-xl font-semibold mb-4">Інформація про замовлення</h2>
                        <p class="flex justify-between">
                            <span>Загальна вартість замовлення:</span>
                            <span>{{ $order->total_price }} {{ $order->currency }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span>Доставка:</span>
                            <span>{{ $order->cost_delivery }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span>Метод оплати:</span>
                            <span>{{ $order->paymentMethod->title }}</span>
                        </p>
                        <div class="mb-4">
                            <label for="comment" class="block text-gray-900">Коментар</label>
                            <textarea name="comment" id="comment" class="w-full border rounded px-3 py-2 h-20 flex justify-between">{{ $order->comment }}</textarea>
                        </div>
                        <p class="flex justify-between">
                            <span>Спосіб доставки:</span>
{{--                            <span>{{ $order->deliveryMethod->deliveryService->delivery_title }} - {{ $order->deliveryMethod->method_title }}<br> {{ $order->deliveryAddress->region->title }} <br> {{ $order->deliveryAddress->city }} <br> {{ $order->deliveryAddress->address }}</span>--}}
                        </p>
                        <hr class="my-4">
                        <div class="flex flex-col space-y-2">
                            <a class="text-center bg-gray-300 py-2 rounded hover:bg-gray-400 transition duration-300" href="{{ route('site.order.index') }}">
                                Назад
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
