<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="w-full mx-auto py-12" style="max-width: 114rem">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @include('admin.orders.header')

                <form action="{{ route('operator.order.updateSecond', $order->id ) }}" method="post">
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
                            <tr class="text-center odd:bg-gray-200 order_detail_div">
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
                                    <input type="number" name="product[{{ $orderDetail->id }}][quantity_product]" value="{{ $orderDetail->quantity_product }}" class="border rounded px-3 py-2">
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
                                    <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border" onclick="deleteOrderDetail(this, {{ $orderDetail->id }})">Видалити</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div id="product-container"></div>
                    <div class="flex justify-end">
                        <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border mb-4" onclick="addAdditionalProduct(this)">Додати товар</button>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <a class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border" style="padding: 10px 41px" href="{{ route('operator.order.editFirst', $order->id) }}">
                            Назад
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">
                            Продовжити
                        </button>
                    </div>
                </form>
                @if (!empty($order->orderDetails()->get()))
                    @foreach ($order->orderDetails()->get() as $orderDetail)
                        <form action="{{ route('operator.order_detail.destroy', $orderDetail->id) }}" method="POST" id="order_detail_{{ $orderDetail->id }}">
                            @csrf
                            @method("DELETE")
                        </form>
                    @endforeach
                @endif
            </div>
        </section>
    </main>
</x-app-layout>

<script>
    function addAdditionalProduct(button) {
        const productContainer = document.getElementById('product-container');
        const productDiv = document.createElement('div');
        productDiv.classList.add('product_div', 'border', 'border-gray-500', 'rounded', 'p-4', 'mb-4');
        const productDivCount = document.querySelectorAll('.product_div').length;
        const countProductDiv = productDivCount + 1;
        productDiv.innerHTML = `
            <h2>Додатковий продукт до замовлення ${countProductDiv}</h2>
            <div class="mb-4">
                <label for="additionalProduct[${countProductDiv}][code]" class="block mb-2 font-bold">Додати код :</label>
                <input type="text" name="additionalProduct[${countProductDiv}][code]" id="additionalProduct[${countProductDiv}][code]" class="w-full border rounded px-3 py-2" oninput="loadProducts(${countProductDiv})">
            </div>

            <div class="mb-4">
                <label for="additionalProduct[${countProductDiv}][product_variant_id]" class="block mb-2 font-bold">Виберіть товар</label>
                <select name="additionalProduct[${countProductDiv}][product_variant_id]" id="additionalProduct[${countProductDiv}][product_variant_id]" class="w-full border rounded px-3 py-2">
                    <option value="">Виберіть товар</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="additionalProduct[${countProductDiv}][quantity]" class="block mb-2 font-bold">Вкажіть кількість товару</label>
                <input type="number" name="additionalProduct[${countProductDiv}][quantity]" id="additionalProduct[${countProductDiv}][quantity]" class="w-full border rounded px-3 py-2">
            </div>

            <div class="text-right">
                <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out" onclick="deleteAdditionalProduct(this)">Видалити додатковий товар</button>
            </div>
        `;
        productContainer.appendChild(productDiv);
    }

    function loadProducts(countProductDiv) {
        const codeInput = document.getElementById(`additionalProduct[${countProductDiv}][code]`);
        const selectProduct = document.getElementById(`additionalProduct[${countProductDiv}][product_variant_id]`);

        fetch(`/operator/orders/add-additional-product/update?code=${codeInput.value}`)
            .then(response => response.json())
            .then(data => {
                selectProduct.innerHTML = '<option value="">Виберіть товар</option>';

                console.log(data)

                data.forEach(product => {
                    if (Array.isArray(product.product_variants)) {
                        product.product_variants.forEach(variant => {
                            const option = document.createElement('option');
                            option.value = variant.id;
                            const colorTitle = variant.color ? variant.color.title : 'N/A';
                            const sizeTitle = variant.size ? variant.size.title : 'N/A';
                            option.textContent = `${product.code} - ${product.title} - ${colorTitle} - ${sizeTitle} - ${variant.quantity}`;
                            selectProduct.appendChild(option);
                        });
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
    }

    function deleteAdditionalProduct(button) {
        const productDiv = button.closest('.product_div');
        productDiv.remove();
    }

    function deleteOrderDetail(button, orderDetailId) {
        const orderDetailContainer = button.closest('.order_detail_div');
        if (orderDetailId) {
            let form_id = '#order_detail_' + orderDetailId;
            let form = document.querySelector(form_id);

            form.submit();
        }
        orderDetailContainer.remove();
    }
</script>



