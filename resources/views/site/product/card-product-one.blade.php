<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-semibold mb-6 text-center">Продукт</h1>
                        <div class="bg-white p-4 rounded-lg shadow-lg flex flex-col items-center relative">
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
                                        <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-40 w-auto rounded-md object-cover mb-4" loading="lazy">
                                    </div>
                                @endif
                            @endforeach
                            <div class="absolute top-10 m-2 text-red-500" style="right: 16px">
                                <a href="#" id="heartLink">
                                    @if(!$likedProduct)
                                        <svg version="1.1" id="Layer_2" xmlns="http://www.w3.org/2000/svg" width="25px" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                                            <path d="M50,91.5C50,91.5,50,91.5,50,91.5c-0.8,0-1.6-0.3-2.2-0.9L8.5,51.1c-4.9-4.8-7.5-11.6-7.3-18.7c0.4-7.1,3.7-13.8,9.1-18.4
                                                c4.5-3.6,9.9-5.5,15.6-5.5c6.9,0,13.7,2.8,18.6,7.7l5.5,5.5l5.5-5.4c9.6-9.6,24.3-10.5,34.2-2c5.4,4.3,8.7,10.8,9.1,17.9
                                                c0.4,7.1-2.3,14.1-7.3,19.1L52.1,90.7C51.6,91.2,50.8,91.5,50,91.5z M48.6,87.1C48.6,87.1,48.6,87.1,48.6,87.1L48.6,87.1z
                                                M25.9,13.5c-4.6,0-8.9,1.5-12.5,4.4c-4.3,3.7-7,9-7.3,14.7C6,38.3,8.1,43.7,12,47.5l38,38.2l38-38c4-4,6.1-9.7,5.8-15.3
                                                c-0.3-5.6-2.9-10.8-7.3-14.3c-7.9-6.8-19.7-6.1-27.5,1.7l-9,8.9l-9-9C37.1,15.7,31.5,13.5,25.9,13.5z"/>
                                        </svg>
                                    @else
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             width="25px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                                            <path d="M14.708,15.847C14.252,14.864,14,13.742,14,12.5s0.252-2.489,0.708-3.659c0.455-1.171,1.114-2.266,1.929-3.205
                                            c0.814-0.938,1.784-1.723,2.86-2.271C20.574,2.814,21.758,2.5,23,2.5s2.426,0.252,3.503,0.707c1.077,0.456,2.046,1.115,2.86,1.929
                                            c0.813,0.814,1.474,1.784,1.929,2.861C31.749,9.073,32,10.258,32,11.5s-0.252,2.427-0.708,3.503
                                            c-0.455,1.077-1.114,2.047-1.929,2.861C28.55,18.678,17.077,29.044,16,29.5l0,0l0,0C14.923,29.044,3.45,18.678,2.636,17.864
                                            c-0.814-0.814-1.473-1.784-1.929-2.861C0.252,13.927,0,12.742,0,11.5s0.252-2.427,0.707-3.503
                                            C1.163,6.92,1.821,5.95,2.636,5.136C3.45,4.322,4.42,3.663,5.497,3.207C6.573,2.752,7.757,2.5,9,2.5s2.427,0.314,3.503,0.863
                                            c1.077,0.55,2.046,1.334,2.861,2.272c0.814,0.939,1.473,2.034,1.929,3.205C17.748,10.011,18,11.258,18,12.5s-0.252,2.364-0.707,3.347
                                            c-0.456,0.983-1.113,1.828-1.929,2.518"/>
                                        </svg>
                                    @endif
                                </a>
                            </div>
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
                    <button type="button" onclick="addForm(this, {{ $product->id }})" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full">Додати коментар</button>
                    @include('site.product.include-views.related-products')
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
                const colorSelect = document.getElementById('color_id_popup');
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

                document.getElementById('color_id_popup').addEventListener('change', function () {
                    console.log('123')
                    const colorId = this.value;
                    const sizeContainer = document.getElementById('size-container');
                    const sizeSelect = document.getElementById('size_id_popup');

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
        const colorSelect = document.getElementById('color_id_popup');
        colorSelect.innerHTML = '';

        const sizeContainer = document.getElementById('size-container');
        const sizeSelect = document.getElementById('size_id_popup');
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

    document.addEventListener("DOMContentLoaded", () => {
        const heartLink = document.getElementById('heartLink');
        let isLiked = {{ json_encode($likedProduct) }};

        function updateHeartIcon() {
            if (isLiked) {
                heartLink.innerHTML = `<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 width="25px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                <path d="M14.708,15.847C14.252,14.864,14,13.742,14,12.5s0.252-2.489,0.708-3.659c0.455-1.171,1.114-2.266,1.929-3.205
                c0.814-0.938,1.784-1.723,2.86-2.271C20.574,2.814,21.758,2.5,23,2.5s2.426,0.252,3.503,0.707c1.077,0.456,2.046,1.115,2.86,1.929
                c0.813,0.814,1.474,1.784,1.929,2.861C31.749,9.073,32,10.258,32,11.5s-0.252,2.427-0.708,3.503
                c-0.455,1.077-1.114,2.047-1.929,2.861C28.55,18.678,17.077,29.044,16,29.5l0,0l0,0C14.923,29.044,3.45,18.678,2.636,17.864
                c-0.814-0.814-1.473-1.784-1.929-2.861C0.252,13.927,0,12.742,0,11.5s0.252-2.427,0.707-3.503
                C1.163,6.92,1.821,5.95,2.636,5.136C3.45,4.322,4.42,3.663,5.497,3.207C6.573,2.752,7.757,2.5,9,2.5s2.427,0.314,3.503,0.863
                c1.077,0.55,2.046,1.334,2.861,2.272c0.814,0.939,1.473,2.034,1.929,3.205C17.748,10.011,18,11.258,18,12.5s-0.252,2.364-0.707,3.347
                c-0.456,0.983-1.113,1.828-1.929,2.518"/>
                </svg>`;
            } else {
                heartLink.innerHTML = `<svg version="1.1" id="Layer_2" xmlns="http://www.w3.org/2000/svg" width="25px" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                <path d="M50,91.5C50,91.5,50,91.5,50,91.5c-0.8,0-1.6-0.3-2.2-0.9L8.5,51.1c-4.9-4.8-7.5-11.6-7.3-18.7c0.4-7.1,3.7-13.8,9.1-18.4
                    c4.5-3.6,9.9-5.5,15.6-5.5c6.9,0,13.7,2.8,18.6,7.7l5.5,5.5l5.5-5.4c9.6-9.6,24.3-10.5,34.2-2c5.4,4.3,8.7,10.8,9.1,17.9
                    c0.4,7.1-2.3,14.1-7.3,19.1L52.1,90.7C51.6,91.2,50.8,91.5,50,91.5z M48.6,87.1C48.6,87.1,48.6,87.1,48.6,87.1L48.6,87.1z
                    M25.9,13.5c-4.6,0-8.9,1.5-12.5,4.4c-4.3,3.7-7,9-7.3,14.7C6,38.3,8.1,43.7,12,47.5l38,38.2l38-38c4-4,6.1-9.7,5.8-15.3
                    c-0.3-5.6-2.9-10.8-7.3-14.3c-7.9-6.8-19.7-6.1-27.5,1.7l-9,8.9l-9-9C37.1,15.7,31.5,13.5,25.9,13.5z"/>
            </svg>`;
            }
        }

        heartLink.addEventListener('click', (event) => {
            event.preventDefault();
            if (isLiked) {
                removeProductFromLiked();
            } else {
                addProductToLiked();
            }
        });

        function addProductToLiked() {
            const productId = {{ $product->id }};
            fetch(`/product/likedProduct/${productId}`)
                .then(response => response.json())
                .catch(error => {
                    console.error('Error fetching product:', error);
                });
            isLiked = true;
            updateHeartIcon();
        }

        function removeProductFromLiked() {
            const productId = {{ $product->id }};
            fetch(`/product/unlinkedProduct/${productId}`)
                .then(response => response.json())
                .catch(error => {
                    console.error('Error fetching product:', error);
                });
            isLiked = false;
            updateHeartIcon();
        }

        updateHeartIcon();
    });
</script>
