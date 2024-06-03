<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-semibold mb-6 text-center">Продукти</h1>

                    <div class="mb-6 text-right">
                        <form method="GET" action="{{ route('site.catalog.show', $category->id) }}" class="inline-block">
                            <label for="sort" class="mr-2">Сортувати за:</label>
                            <select name="sort" id="sort" onchange="this.form.submit()" class="border rounded px-2 py-1">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Новизна</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Ціна: від низької до високої</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Ціна: від високої до низької</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Назва: від А до Я</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Назва: від Я до А</option>
                            </select>
                        </form>
                    </div>

                    @if(!empty($categories))
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($categories as $category)
                                @include('site.catalog.second-part-catalog')
                            @endforeach
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($products as $product)
                                <div class="bg-white p-4 rounded-lg shadow-lg flex flex-col items-center">
                                    @foreach($product->getMedia($product->id) as $media)
                                        @if($media->getCustomProperty('main_image') === 1)
                                            <a href="{{ route('site.product.showOneProduct', $product->id) }}">
                                                <img src="{{ $media->getUrl() }}"
                                                     alt="{{ $media->getCustomProperty('alt') }}"
                                                     class="h-40 w-auto rounded-md object-cover mb-4">
                                            </a>
                                        @endif
                                    @endforeach
                                    <div class="text-center">
                                        <a href="{{ route('site.product.showOneProduct', $product->id) }}">
                                            <p class="text-xl font-semibold mb-2">{{ $product->title }}</p>
                                        </a>
                                        @if($product->package)
                                            <p class="text-lg mb-2">В упаковці: {{ $product->package->title }}</p>
                                        @endif
                                        <p class="text-lg mb-2">Колір, розмір, доступно:</p>
                                        @foreach($product->productVariants()->get() as $productVariant)
                                            <ul class="text-lg mb-2">
                                                <li>{{ $productVariant->color->title }}
                                                    - {{ $productVariant->size->title }}
                                                    - {{ $productVariant->quantity }}</li>
                                            </ul>
                                        @endforeach

                                        @if($product->price()->get())
                                            @foreach($product->price()->get() as $price)
                                                @include('site.product.price.index')
                                            @endforeach
                                        @else
                                            <p class="text-lg mb-2">Ціна не вказана</p>
                                        @endif
                                        @if($product->status_id == 1)
                                            <button onclick="openPopup({{ $product->id }})"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 w-full border">
                                                В кошик
                                            </button>
                                        @else
                                            {{ $product->status->title }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Popup Modal -->
    <div id="popupModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Виберіть колір і розмір</h3>
                <div class="mt-2 px-7 py-3">
                    <form id="cart_form_popup" action="{{ route('cart.store') }}" method="post">
                        @csrf
                        <input type="hidden" id="popup_product_id" name="product_id" value="">
                        @error('color_id')
                        <span class="text-red-500">{{ htmlspecialchars("Виберіть обов'язково колір товару, щоб добавити його в кошик") }}</span>
                        @enderror
                        <label for="color_id" class="block mb-2 font-bold">Виберіть колір:</label>
                        <select name="color_id" id="color_id" class="w-full border rounded px-3 py-2">
                            <option value="" selected>Виберіть колір</option>
                        </select>
                        <div id="size-container" class="mt-4 hidden">
                            @error('size_id')
                            <span class="text-red-500">{{ htmlspecialchars("Виберіть обов'язково розмір товару, щоб добавити його в кошик") }}</span>
                            @enderror
                            <label for="size_id" class="block mb-2 font-bold">Виберіть розмір:</label>
                            <select name="size_id" id="size_id" class="w-full border rounded px-3 py-2">
                                <option value="" selected>Виберіть Розмір</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full">
                                Додати в кошик
                            </button>
                        </div>
                    </form>
                </div>
                <div class="items-center px-4 py-3">
                    <button onclick="closePopup()"
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Закрити
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function openPopup(productId) {
        document.getElementById('popup_product_id').value = productId;
        document.getElementById('popupModal').classList.remove('hidden');

        fetch(`/product/get-product/${productId}`)
            .then(response => response.json())
            .then(productData => {
                const colorSelect = document.getElementById('color_id');
                colorSelect.innerHTML = '';
                const firstOption = document.createElement('option');
                firstOption.value = '';
                firstOption.textContent = 'Виберіть колір';
                colorSelect.appendChild(firstOption);

                productData.productVariants.forEach(variant => {
                    const option = document.createElement('option');
                    option.value = variant.color.id;
                    option.textContent = variant.color.title;
                    colorSelect.appendChild(option);
                });

                document.getElementById('color_id').addEventListener('change', function () {
                    const colorId = this.value;
                    const sizeContainer = document.getElementById('size-container');
                    const sizeSelect = document.getElementById('size_id');

                    sizeSelect.innerHTML = '';

                    fetch(`/product/get-sizes/${productId}`)
                        .then(response => response.json())
                        .then(data => {
                            sizeContainer.classList.remove('hidden');
                            data.sizeVariants.forEach(size => {
                                const option = document.createElement('option');
                                if (size.color_id == colorId) {
                                    option.value = size.size.id;
                                    option.textContent = size.size.title;
                                    sizeSelect.appendChild(option);
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching sizes:', error);
                            sizeContainer.classList.add('hidden');
                        });
                });
            })
            .catch(error => console.error('Error fetching product data:', error));
    }

    function closePopup() {
        const colorSelect = document.getElementById('color_id');
        colorSelect.innerHTML = '';

        const sizeContainer = document.getElementById('size-container');
        const sizeSelect = document.getElementById('size_id');
        sizeSelect.innerHTML = '';
        sizeContainer.classList.add('hidden');

        document.getElementById('popupModal').classList.add('hidden');
        location.reload();
    }
</script>
