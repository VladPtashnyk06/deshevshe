<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Додати акційний товар</h2>
                <div class="text-center mb-4">
                    <form action="{{ route('promotional.create') }}" method="GET" style="display: flex; align-items: center; justify-content: center;">
                        <div class="mb-4 mr-4" style="flex: 1;">
                            <label for="code" class="block mb-2 font-bold">Код товару:</label>
                            <input type="text" name="code" id="code" class="w-full" value="{{ !empty(request()->input('code')) ? request()->input('code') : '' }}">
                        </div>
                        <div class="mb-4" style="flex: 1;">
                            <label for="title" class="block mb-2 font-bold">Назва товару:</label>
                            <input type="text" name="title" id="title" class="w-full" value="{{ !empty(request()->input('title')) ? request()->input('title') : '' }}">
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
                                <button type="button" onclick="window.location='{{ route('promotional.create') }}'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border ml-2">Очистити фільтри</button>
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
                        <th class="p-2 text-lg">К-сть. в упакуванні</th>
                        <th class="p-2 text-lg">Виробник</th>
                        <th class="p-2 text-lg">Ціна за пару</th>
                        <th class="p-2 text-lg">Дії</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        @foreach($product->productVariants()->get() as $productVariant)
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
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $productVariant->color->title }}<br></td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $productVariant->size->title }}<br></td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $productVariant->quantity }}<br></td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ isset($product->package->title) ? $product->package->title : 'Не вказано' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->producer->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->price->pair }}</td>
                                <td class="px-6 py-4 text-right" style="vertical-align: top;">
                                    <a href="#" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border open-popup" data-product="{{ json_encode($product) }}" data-product-id="{{ $product->id }}" data-product-variant-id="{{ $productVariant->id }}" data-code="{{ $product->code }}" data-title="{{ $product->title }}" data-color="{{ $productVariant->color->title }}" data-size="{{ $productVariant->size->title }}" data-price="{{ $product->price->pair }}">Додати</a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="promotional-popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50 bg-gray-500">
        <div class="bg-white p-8 rounded-lg shadow-lg mx-auto max-w-7xl relative">
            <button class="close-popup absolute text-gray-600 hover:text-gray-900 transition duration-300 ease-in-out" style="top: 4px; right: 4px;">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div class="p-6 text-gray-900">
                <div class="text-center" style="margin: 4px">
                    <form action="{{ route('promotional.store') }}" method="post">
                        @csrf

                        <input type="hidden" name="productId" id="productId" value="">
                        <input type="hidden" name="productVariantId" id="productVariantId" value="">
                        <table class="w-full mb-5">
                            <thead>
                            <tr class="text-center border-b-2 border-gray-700">
                                <th class="p-2 text-lg">Зображення</th>
                                <th class="p-2 text-lg">Код товару</th>
                                <th class="p-2 text-lg">Назва товару</th>
                                <th class="p-2 text-lg">Колір</th>
                                <th class="p-2 text-lg">Розмір</th>
                                <th class="p-2 text-lg">Ціна за пару</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-6 py-4" id="popup-image" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;"></td>
                                <td class="px-6 py-4" id="popup-code" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;"></td>
                                <td class="px-6 py-4" id="popup-title" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;"></td>
                                <td class="px-6 py-4" id="popup-color" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;"></td>
                                <td class="px-6 py-4" id="popup-size" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;"></td>
                                <td class="px-6 py-4" id="popup-price" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;"></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6 flex-1">
                            <div class="mb-4">
                                <label for="promotionalRate" class="block mb-2 font-bold">Знижка %:</label>
                                <input type="number" min="0" max="80" class="w-full border rounded px-3 py-2" name="promotionalRate" id="promotionalRate" value="">
                            </div>
                            <div class="mb-4">
                                <label for="promotionalPrice" class="block mb-2 font-bold">Ціна зі знижкою %:</label>
                                <input type="text" class="w-full border rounded px-3 py-2" name="promotionalPrice" id="promotionalPrice" value="" disabled>
                            </div>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full">
                            Додати
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function calculatePromotionalPrice(originalPrice, discountRate) {
        return originalPrice - (originalPrice * (discountRate / 100));
    }

    const promotionalRate = document.getElementById('promotionalRate');
    const promotionalPrice = document.getElementById('promotionalPrice');
    promotionalRate.addEventListener('change', function() {
        const discountRate = promotionalRate.value;
        const originalPrice = parseFloat(document.getElementById('popup-price').dataset.price);
        promotionalPrice.value = calculatePromotionalPrice(originalPrice, discountRate).toFixed(2);
    });

    document.querySelectorAll('.open-popup').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            const product = JSON.parse(button.getAttribute('data-product'));
            const productVariantId = button.getAttribute('data-product-variant-id');
            const code = button.getAttribute('data-code');
            const title = button.getAttribute('data-title');
            const color = button.getAttribute('data-color');
            const size = button.getAttribute('data-size');
            const price = button.getAttribute('data-price');

            document.getElementById('productId').value = product.id;
            document.getElementById('productVariantId').value = productVariantId;
            document.getElementById('popup-code').textContent = code;
            document.getElementById('popup-title').textContent = title;
            document.getElementById('popup-color').textContent = color;
            document.getElementById('popup-size').textContent = size;
            document.getElementById('popup-price').textContent = price;
            document.getElementById('popup-price').dataset.price = price;

            const mainImage = product.media.find(media => media.custom_properties.main_image === 1);
            if (mainImage) {
                document.getElementById('popup-image').innerHTML = `
                <img src="${mainImage.original_url}" alt="${mainImage.custom_properties.alt}" class="h-16 w-auto rounded-md object-cover">
            `;
            }

            document.getElementById('promotional-popup').classList.remove('hidden');
        });
    });

    document.querySelector('.close-popup').addEventListener('click', function() {
        document.getElementById('promotional-popup').classList.add('hidden');
    });

</script>
