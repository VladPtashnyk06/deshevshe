<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-semibold mb-6 text-center">Продукт</h1>
                    <form id="cart_form_{{ $product->id }}" action="{{ route('cart.store') }}" method="post">
                        @csrf
                        <div class="bg-white p-4 rounded-lg shadow-lg flex flex-col items-center">
                            @foreach($product->getMedia($product->id) as $media)
                                @if($media->getCustomProperty('main_image') === 1)
                                    <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-40 w-auto rounded-md object-cover mb-4">
                                @endif
                            @endforeach
                            <div class="text-center">
                                <p class="text-xl font-semibold mb-2">{{ $product->title }}</p>
                                @if($product->package)
                                    <p class="text-lg mb-2">В упаковці: {{ $product->package->title }}</p>
                                @endif

                                <label for="color_id" class="block mb-2 font-bold">Виберіть колір:</label>
                                <select name="color_id" id="color_id" class="w-full border rounded px-3 py-2">
                                    <option value="" disabled selected>Виберіть колір</option>
                                    @foreach($product->productVariants()->get() as $productVariant)
                                        <option value="{{ $productVariant->color->id }}">{{ $productVariant->color->title }}</option>
                                    @endforeach
                                </select>

                                <div id="size-container" class="mt-4 hidden">
                                    <label for="size_id" class="block mb-2 font-bold">Виберіть розмір:</label>
                                    <select name="size_id" id="size_id" class="w-full border rounded px-3 py-2">
                                        <!-- Опції для розмірів додати тут -->
                                    </select>
                                </div>

                                @if($product->price()->get())
                                    @foreach($product->price()->get() as $price)
                                        <p class="text-lg mb-2">Ціна за шт - {{ $price->pair }} грн.</p>
                                        <p class="text-lg mb-2">Ціна за пакування - {{ $price->package }} грн.</p>
                                        <p class="text-lg mb-2">Рекомендована ціна для продажу у роздріб - {{ $price->rec_pair }} грн.</p>
                                    @endforeach
                                @else
                                    <p class="text-lg mb-2">Ціна не вказана</p>
                                @endif
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 w-full border" type="submit" name="product_id" value="{{ $product->id }}">
                                    В кошик
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('color_id').addEventListener('change', function() {
            const colorId = this.value;
            const sizeContainer = document.getElementById('size-container');
            const sizeSelect = document.getElementById('size_id');

            sizeSelect.innerHTML = '';

            fetch(`/product/get-sizes/${colorId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        sizeContainer.classList.remove('hidden');
                        data.forEach(size => {
                            const option = document.createElement('option');
                            option.value = size.size_id;
                            option.textContent = `${size.size_title}`;
                            sizeSelect.appendChild(option);
                        });
                    } else {
                        sizeContainer.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error fetching sizes:', error);
                    sizeContainer.classList.add('hidden');
                });
        });
    </script>
</x-app-layout>
