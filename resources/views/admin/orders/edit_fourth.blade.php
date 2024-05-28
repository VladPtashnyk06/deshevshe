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
                        <h2 class="font-bold">Загальна сума: {{ $order->total_price }} {{ $order->currency }}</h2>
                    </div>

                    <div class="mb-4">
                        <div class="space-y-1 relative mb-4" id="branchesContainer">
                            <input type="hidden" id="branchRefHidden" name="branchRefHidden" value="{{ $order->delivery->branch }}">
                            <input type="hidden" id="cityRefHidden" name="cityRefHidden" value="{{ $order->delivery->cityRef }}">
                            <label for="branchesInput" class="block font-semibold">Відділення Нової пошти</label>
                            <input id="branchesInput" name="branch" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення" value="{{ $order->delivery->branch }}">
                            <ul id="branchesList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                <!-- Відділення будуть відображені тут -->
                            </ul>
                        </div>
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
                        <label for="cupon" class="block mb-2 font-bold">Купон</label>
                        <input type="text" name="cupon" id="cupon" class="w-full border rounded px-3 py-2" value="">
                    </div>

                    <div class="mb-4">
                        <label for="balu" class="block mb-2 font-bold">Бали</label>
                        <input type="text" name="balu" id="balu" class="w-full border rounded px-3 py-2" value="">
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
            </div>
        </section>
    </main>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const branchesInput = document.getElementById('branchesInput');
        const branchesList = document.getElementById('branchesList');
        const cityRefHidden = document.getElementById('cityRefHidden');
        const branchRefHidden = document.getElementById('branchRefHidden');

        branchesInput.addEventListener('input', function() {
            const cityRef = cityRefHidden.value;
            console.log(cityRef);
            const searchText = this.value.trim().toLowerCase();
            if (cityRef && searchText.length >= 0) {
                fetchBranches(cityRef, searchText);
            } else {
                branchesList.innerHTML = '';
                branchesList.classList.add('hidden');
            }
        });

        function fetchBranches(cityRef, searchText) {
            fetch('/branches', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ city: cityRef, search: searchText })
            })
                .then(response => response.json())
                .then(data => {
                    branchesList.innerHTML = '';
                    data.forEach(branch => {
                        if (branch.Description.toLowerCase().includes(searchText)) {
                            const listItem = document.createElement('li');
                            listItem.textContent = branch.Description;
                            listItem.setAttribute('data-value', branch.Ref);
                            listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                            listItem.addEventListener('click', function() {
                                branchesInput.value = this.textContent;
                                branchRefHidden.value = branch.Ref;
                                branchesList.classList.add('hidden');
                            });
                            branchesList.appendChild(listItem);
                        }
                    });
                    if (branchesList.children.length > 0) {
                        branchesList.classList.remove('hidden');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
</script>

