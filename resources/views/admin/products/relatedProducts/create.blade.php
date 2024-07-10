<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 114rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Головний товар</h1>
                    <table class="w-full mb-5">
                        <thead>
                        <tr class="text-center border-b-2 border-gray-700">
                            <th class="p-2 text-lg">Зображення</th>
                            <th class="p-2 text-lg">Код товару</th>
                            <th class="p-2 text-lg">Назва товару</th>
                            <th class="p-2 text-lg">Категорія</th>
                            <th class="p-2 text-lg">Колір</th>
                            <th class="p-2 text-lg">Розмір</th>
                            <th class="p-2 text-lg">Роздрібна ціна</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                    @foreach($mainProduct->getMedia($mainProduct->id) as $media)
                                        @if($media->getCustomProperty('main_image') === 1)
                                            <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-16 w-auto rounded-md object-cover">
                                        @endif
                                    @endforeach
                                </td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $mainProduct->code }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $mainProduct->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $mainProduct->category->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                    @foreach($mainProduct->productVariants()->get() as $productVariant)
                                        {{ $productVariant->color->title }}<br>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                    @foreach($mainProduct->productVariants()->get() as $productVariant)
                                        {{ $productVariant->size->title }}<br>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $mainProduct->price->retail }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <a href="{{ route('related-product.index', $mainProduct->id) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full mb-2" style="display: block;text-align: center;font-weight: bold;padding: 0.5rem 1rem;border-radius: 0.375rem;transition: background-color 0.3s ease-in-out;">
                            Назад
                        </a>
                    </div>
                </div>
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Товари</h1>
                    <div class="text-center mb-4">
                        <form action="{{ route('related-product.create', $mainProduct->id) }}" method="GET" style="display: flex; align-items: center; justify-content: center;">
                            <div class="mb-4" style="flex: 1;">
                                <label for="code" class="block mb-2 font-bold">Код товару:</label>
                                <input type="text" name="code" id="code" class="w-full" value="{{ !empty(request()->input('code')) ? request()->input('code') : '' }}">
                            </div>
                            <div class="mb-4 ml-4" style="flex: 1;">
                                <label for="producer_id" class="block mb-2 font-bold">Виробники:</label>
                                <select name="producer_id" id="producer_id" class="w-full border rounded px-3 py-2">
                                    <option value="">Усі виробники</option>
                                    @foreach ($producers as $producer)
                                        <option value="{{ $producer->id }}" @if(request()->input('producer_id') == $producer->id) selected @endif>{{ $producer->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4 ml-4" style="flex: 1;">
                                <label for="category_id" class="block mb-2 font-bold">Категорії:</label>
                                <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2">
                                    <option value="">Усі категорії</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if(request()->input('category_id') == $category->id) selected @endif>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="ml-2 mb-4">
                                <div class="mt-4">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">Застосувати фільтри</button>
                                    <button type="button" onclick="window.location='{{ route('related-product.create', $mainProduct->id) }}'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border ml-2">Очистити фільтри</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table class="w-full mb-5">
                        <thead>
                        <tr class="text-center border-b-2 border-gray-700">
                            <th class="p-2 text-lg">Зображення</th>
                            <th class="p-2 text-lg">Код товару</th>
                            <th class="p-2 text-lg">Назва товару</th>
                            <th class="p-2 text-lg">Категорія</th>
                            <th class="p-2 text-lg">Колір</th>
                            <th class="p-2 text-lg">Розмір</th>
                            <th class="p-2 text-lg">Кількість товару</th>
                            <th class="p-2 text-lg">Виробник</th>
                            <th class="p-2 text-lg">Роздрібна ціна</th>
                            <th class="p-2 text-lg">Дії</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            @if($product->id !== $mainProduct->id)
                                <tr class="text-center odd:bg-gray-200">
                                    <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                        @foreach($product->getMedia($product->id) as $media)
                                            @if($media->getCustomProperty('main_image') === 1)
                                                <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-16 w-auto rounded-md object-cover">
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->code }}</td>
                                    <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->title }}</td>
                                    <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->category->title }}</td>
                                    <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                        @foreach($product->productVariants()->get() as $productVariant)
                                            {{ $productVariant->color->title }}<br>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                        @foreach($product->productVariants()->get() as $productVariant)
                                            {{ $productVariant->size->title }}<br>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                        @foreach($product->productVariants()->get() as $productVariant)
                                            {{ $productVariant->quantity }}<br>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->producer->title }}</td>
                                    <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->price->retail }}</td>
                                    <td class="px-6 py-4 text-right flex" style="vertical-align: top;">
                                        <a href="javascript:void(0);" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full mb-2" style="display: block; text-align: center; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.375rem; transition: background-color 0.3s ease-in-out;" onclick="addRelatedProduct({{ $mainProduct->id }}, {{ $product->id }})">
                                            Додати
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function addRelatedProduct(mainProductId, relatedProductId) {
    fetch(`/admin/product/related-products/store/${mainProductId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ related_product_id: relatedProductId })
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.message || 'Щось пішло не так');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Товар доданий, як супутній');
            } else {
                alert(`Помилка додавання товару: ${data.message}`);
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
