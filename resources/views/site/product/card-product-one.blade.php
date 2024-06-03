<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-semibold mb-6 text-center">Продукт</h1>
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

                                @if($product->price()->get())
                                    @foreach($product->price()->get() as $price)
                                        @include('site.product.price.index')
                                    @endforeach
                                @else
                                    <p class="text-lg mb-2">Ціна не вказана</p>
                                @endif
                                @if($product->status_id == 1)
                                    <button onclick="openPopup({{ $product->id }})"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 w-full border" type="submit" name="product_id" value="{{ $product->id }}">
                                        В кошик
                                    </button>
                                @else
                                    {{ $product->status->title }}
                                @endif
                                <a href="{{ route('site.catalog.show', $product->category_id) }}" class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md text-center transition duration-300 ease-in-out">Назад</a>
                            </div>
                        </div>
                    @if($product->comments->count() > 0)
                        @foreach($product->comments as $comment)
                            <div class="mb-6 bg-gray-100 p-4 rounded-lg">
                                <p class="font-semibold mb-2">{{ $comment->name }}</p>
                                <p class="text-gray-600 mb-2">{{ $comment->created_at }}</p>
                                <p>{{ $comment->comment }}</p>
                                <button type="button" onclick="addFormAnswer(this, {{ $comment->id }})" class="mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">Відповісти на коментар</button>
                            </div>
                        @endforeach
                    @endif
                    <button type="button" onclick="addForm(this, {{ $product->id }})" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">Додати коментар</button>
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

    function addFormAnswer(element) {
        const form = `
            <form action="{{ route('site.product.comment.store') }}" method="post" class="max-w-lg mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                @if(isset($comment))
                    <input type="hidden" name="parent_comment_id" value="{{ $comment->id }}">
                    <input type="hidden" name="product_id" value="{{ $comment->product_id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user() ? Auth::user()->id : null }}">
                    <input type="hidden" name="level" value="{{ $comment->level + 1}}">
                @endif

                <div class="w-full grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        @error('name')
                            <span class="text-red-500">{{ htmlspecialchars("Будь ласка, не більше 255 символів") }}</span>
                        @enderror
                        <label for="name" class="block mb-2 font-bold">Ім'я</label>
                        <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" value="{{ Auth::user() ? Auth::user()->name : old('name') }}">
                    </div>
                </div>

                <div class="w-full grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        @error('email')
                            <span class="text-red-500">{{ htmlspecialchars("Будь ласка, не більше 255 символів") }}</span>
                        @enderror
                    <label for="email" class="block mb-2 font-bold">Електрона адреса</label>
                    <input type="text" name="email" id="email" class="w-full border rounded px-3 py-2" value="{{ Auth::user() && Auth::user()->email ? Auth::user()->email : old('email') }}">
                    </div>
                </div>

                <div class="mb-4">
                    @error('comment')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                    @enderror
                    <label for="comment" class="block mb-2 font-bold">Відповідь на коментар</label>
                    <textarea name="comment" id="comment" rows="4" class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <div class="text-center mb-4">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full">Надати відповідь</button>
                </div>
            </form>
        `;
        element.insertAdjacentHTML('afterend', form);
        element.remove();
    }

    function addForm(element) {
        const form = `
            <form action="{{ route('site.product.comment.store') }}" method="post" class="max-w-lg mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf

                <input type="hidden" name="parent_comment_id" value="">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="user_id" value="{{ Auth::user() ? Auth::user()->id : null}}">
                <input type="hidden" name="level" value="1">

                <div class="w-full grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        @error('name')
                        <span class="text-red-500">{{ htmlspecialchars("Будь ласка, не більше 255 символів") }}</span>
                        @enderror
                        <label for="name" class="block mb-2 font-bold">Ім'я</label>
                        <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" value="{{ Auth::user() ? Auth::user()->name : old('name') }}">
                    </div>
                </div>

                <div class="w-full grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        @error('email')
                            <span class="text-red-500">{{ htmlspecialchars("Будь ласка, не більше 255 символів") }}</span>
                        @enderror
                        <label for="email" class="block mb-2 font-bold">Електрона адреса</label>
                        <input type="text" name="email" id="email" class="w-full border rounded px-3 py-2" value="{{ Auth::user() && Auth::user()->email ? Auth::user()->email : old('email') }}">
                    </div>
                </div>

                <div class="mb-4">
                    @error('comment')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                    @enderror
                    <label for="comment" class="block mb-2 font-bold">Коментар</label>
                    <textarea name="comment" id="comment" rows="4" class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <div class="text-center mb-4">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full">Написати коментар</button>
                </div>
            </form>
        `;
        element.insertAdjacentHTML('beforebegin', form);
        element.remove();
    }
</script>
