<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 100rem">
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

                    @if(!empty($categories) && $categories->isNotEmpty())
                        @dump($categories)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($categories as $category)
                                @include('site.catalog.second-part-catalog')
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col lg:flex-row">
                            <!-- Filters section -->
                            <div class="lg:w-1/4 p-4 bg-gray-100 rounded-lg shadow-lg mb-6 lg:mb-0 lg:mr-6">
                                <form method="GET" action="{{ route('site.catalog.show', $category->id) }}" class="inline-block">
                                    <div class="mb-4">
                                        <label for="color_id" class="block mb-2 font-semibold">Колір:</label>
                                        <select name="color_id" id="color_id" onchange="this.form.submit()" class="w-full border rounded px-2 py-1">
                                            <option value="">Виберіть колір</option>
                                            @foreach($colors as $color)
                                                <option value="{{ $color->id }}" {{ request('color_id') == $color->id ? 'selected' : '' }}>{{ $color->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="size_id" class="block mb-2 font-semibold">Розмір:</label>
                                        <select name="size_id" id="size_id" onchange="this.form.submit()" class="w-full border rounded px-2 py-1">
                                            <option value="">Виберіть розмір</option>
                                            @foreach($sizes as $size)
                                                <option value="{{ $size->id }}" {{ request('size_id') == $size->id ? 'selected' : '' }}>{{ $size->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="country_id" class="block mb-2 font-semibold">Країна виробник:</label>
                                        <select name="country_id" id="country_id" onchange="this.form.submit()" class="w-full border rounded px-2 py-1">
                                            <option value="">Виберіть країну</option>
                                            @foreach($producers as $producer)
                                                <option value="{{ $producer->id }}" {{ request('producer_id') == $producer->id ? 'selected' : '' }}>{{ $producer->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="status_id" class="block mb-2 font-semibold">Статус:</label>
                                        <select name="status_id" id="status_id" onchange="this.form.submit()" class="w-full border rounded px-2 py-1">
                                            <option value="">Виберіть статус</option>
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>{{ $status->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>

                            <!-- Products section -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6 flex-1">
                                @if($products->count() > 0)
                                    @foreach($products as $product)
                                        <div class="bg-white p-4 rounded-lg shadow-lg flex flex-col items-center">
                                            @foreach($product->getMedia($product->id) as $media)
                                                @if($media->getCustomProperty('main_image') === 1)
                                                    <div class="relative">
                                                        @if($product->product_promotion)
                                                        <span class="absolute top-0 right-0 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-bl">Акція</span>
                                                        @elseif($product->top_product)
                                                            <span class="absolute top-0 right-0 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-bl">Топ</span>
                                                        @elseif(now()->diffInDays($product->created_at) <= 30)
                                                            <span class="absolute top-0 right-0 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-bl">Новинка</span>
                                                        @endif
                                                        <a href="{{ route('site.product.showOneProduct', $product->id) }}">
                                                            <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-40 w-auto rounded-md object-cover mb-4">
                                                        </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                            <div class="text-center">
                                                <a href="{{ route('site.product.showOneProduct', $product->id) }}">
                                                    <p class="text-xl font-semibold mb-2">{{ $product->title }}</p>
                                                </a>
                                                <div class="mt-4">
                                                    <div class="flex justify-between">
                                                        <div class="flex items-center rating" data-product-id="{{ $product->id }}">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $product->rating)
                                                                    <svg class="w-6 h-6 cursor-pointer star text-gray-400" style="fill: yellow" data-rating="{{ $i }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                        <path d="M10 15l-5.878 3.09 1.122-6.54L.364 7.65l6.564-.954L10 .684l3.072 6.012 6.564.954-4.88 4.9 1.122 6.54z"/>
                                                                    </svg>
                                                                @else
                                                                    <svg class="w-6 h-6 cursor-pointer star text-gray-400" style="fill: gray" data-rating="{{ $i }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                        <path d="M10 15l-5.878 3.09 1.122-6.54L.364 7.65l6.564-.954L10 .684l3.072 6.012 6.564.954-4.88 4.9 1.122 6.54z"/>
                                                                    </svg>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <span class="ml-2 text-gray-600 text-lg" id="rating-value-{{ $product->id }}">{{ $product->rating ? $product->rating : 0 }} / 5</span>
                                                    </div>
                                                </div>
                                            @if($product->package)
                                                    <p class="text-lg mb-2">В упаковці: {{ $product->package->title }}</p>
                                                @endif
                                                <p class="text-lg mb-2">Колір, розмір, доступно:</p>
                                                @if ($color_id || $size_id)
                                                    <ul class="text-lg mb-2">
                                                        @foreach($product->productVariants()->get() as $productVariant)
                                                            @if ((!$color_id || $productVariant->color_id == $color_id) && (!$size_id || $productVariant->size_id == $size_id))
                                                                <li>{{ $productVariant->color->title }} - {{ $productVariant->size->title }} - {{ $productVariant->quantity }}</li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    @foreach($product->productVariants()->get() as $productVariant)
                                                        <ul class="text-lg mb-2">
                                                            <li>{{ $productVariant->color->title }} - {{ $productVariant->size->title }} - {{ $productVariant->quantity }}</li>
                                                        </ul>
                                                    @endforeach
                                                @endif

                                                @if($product->price()->get())
                                                    @foreach($product->price()->get() as $price)
                                                        @include('site.product.price.index')
                                                    @endforeach
                                                @endif
                                                <div class="mt-4">
                                                    @if($product->country_id)
                                                        {{ $product->country->name }}
                                                    @endif
                                                </div>
                                                <div class="mt-4">
                                                    @if($product->status_id)
                                                        {{ $product->status->title }}
                                                    @endif
                                                </div>
                                                <div class="mt-4">
                                                    @if($product->status_id == 1)
                                                        <button onclick="openPopup({{ $product->id }}, 'cart')"
                                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 w-full border">
                                                            В кошик
                                                        </button>
                                                    @endif
                                                </div>
                                                <div class="mt-1">
                                                    @if($product->status_id == 1)
                                                        <button onclick="openPopup({{ $product->id }}, 'buyFast')"
                                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 w-full border">
                                                            Купити бистро
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <h2><b>За таким фільтром товарів в цій категорії немає</b></h2>
                                @endif
                            </div>
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
                    <form id="cart_form_popup" action="" method="post">
                        @csrf

                        <input type="hidden" id="popup_product_id" name="product_id" value="">
                        <input type="hidden" id="action_type" name="action_type" value="">
                        @error('color_id_popup')
                        <span class="text-red-500">{{ htmlspecialchars("Виберіть обов'язково колір товару, щоб добавити його в кошик") }}</span>
                        @enderror
                        <label for="color_id_popup" class="block mb-2 font-bold">Виберіть колір:</label>
                        <select name="color_id_popup" id="color_id_popup" class="w-full border rounded px-3 py-2">
                            <option value="" selected>Виберіть колір</option>
                        </select>
                        <div id="size-container" class="mt-4 hidden">
                            @error('size_id_popup')
                            <span class="text-red-500">{{ htmlspecialchars("Виберіть обов'язково розмір товару, щоб добавити його в кошик") }}</span>
                            @enderror
                            <label for="size_id_popup" class="block mb-2 font-bold">Виберіть розмір:</label>
                            <select name="size_id_popup" id="size_id_popup" class="w-full border rounded px-3 py-2">
                                <option value="" selected>Виберіть Розмір</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full">
                                Підтвердити
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
    function openPopup(productId, actionType) {
        document.getElementById('popup_product_id').value = productId;
        var actionTypeHidden = document.getElementById('action_type');
        document.getElementById('popupModal').classList.remove('hidden');

        const form = document.getElementById('cart_form_popup');
        if (actionType === 'cart') {
            form.action = '{{ route('cart.store') }}';
            actionTypeHidden.value = 'cart';
        } else if (actionType === 'buyFast') {
            form.action = '{{ route('cart.store') }}';
            actionTypeHidden.value = 'buyFast';
        }

        fetch(`/product/get-product/${productId}`)
            .then(response => response.json())
            .then(productData => {
                const colorSelect = document.getElementById('color_id_popup');
                colorSelect.innerHTML = '<option value="" selected>Виберіть колір</option>';

                productData.productVariants.forEach(variant => {
                    const option = document.createElement('option');
                    option.value = variant.color.id;
                    option.textContent = variant.color.title;
                    colorSelect.appendChild(option);
                });

                document.getElementById('color_id_popup').addEventListener('change', function () {
                    const colorId = this.value;
                    const sizeContainer = document.getElementById('size-container');
                    const sizeSelect = document.getElementById('size_id_popup');
                    sizeSelect.innerHTML = '';

                    fetch(`/product/get-sizes/${productId}`)
                        .then(response => response.json())
                        .then(data => {
                            sizeContainer.classList.remove('hidden');
                            data.sizeVariants.forEach(size => {
                                if (size.color_id == colorId) {
                                    const option = document.createElement('option');
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
        document.getElementById('popupModal').classList.add('hidden');
        location.reload();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star');

        stars.forEach(star => {
            star.addEventListener('mouseover', function () {
                const rating = this.getAttribute('data-rating');
                const starElements = this.closest('.rating').querySelectorAll('.star');
                starElements.forEach(star => {
                    if (star.getAttribute('data-rating') <= rating) {
                        star.style = 'fill: yellow';
                    } else {
                        star.style = 'fill: gray';
                    }
                });
            });

            star.addEventListener('mouseout', function () {
                const productId = this.closest('.rating').getAttribute('data-product-id');
                const currentRating = document.getElementById(`rating-value-${productId}`).textContent.split(' ')[0];
                const starElements = this.closest('.rating').querySelectorAll('.star');
                starElements.forEach(star => {
                    if (star.getAttribute('data-rating') <= currentRating) {
                        star.style = 'fill: yellow';
                    } else {
                        star.style = 'fill: gray';
                    }
                });
            });

            star.addEventListener('click', function () {
                const rating = this.getAttribute('data-rating');
                const productId = this.closest('.rating').getAttribute('data-product-id');

                fetch(`/product/rate-product/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        rating: rating
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const ratingValue = document.getElementById(`rating-value-${productId}`);
                            var newRating = Math.round(data.newRating);
                            ratingValue.textContent = `${newRating} / 5`;

                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });
</script>

