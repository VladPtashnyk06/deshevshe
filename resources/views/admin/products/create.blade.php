<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Створити товар</h2>
                <form action="{{ route('product.store') }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <div class="mb-4">
                            @error('main_image')
                            <span class="text-red-500">{{ htmlspecialchars("Ви повинні вибрати фотографію") }}</span>
                            @enderror
                            <label for="main_image" class="block mb-2 font-bold">Головна фотографія</label>
                            <input type="file" name="main_image" id="main_image" class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="w-full grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                @error('alt_for_main_image')
                                <span class="text-red-500">{{ htmlspecialchars("Будь ласка, не більше 255 символів") }}</span>
                                @enderror
                                <label for="alt_for_main_image" class="block mb-2 font-bold">Alt для головної фотографії</label>
                                <input type="text" name="alt_for_main_image" id="alt_for_main_image" class="w-full border rounded px-3 py-2" value="{{ old('alt_for_main_image') }}">
                            </div>
                        </div>
                    </div>

                    <div id="image_container" class="mb-4"></div>

                    <div class="text-center mb-4">
                        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 w-full border" onclick="addNewImagesWithAlt(this)">Додати додаткову фотографію та alt</button>
                    </div>

                    <div class="mb-4">
                        @error('category_id')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="category_id" class="block mb-2 font-bold">Категорія</label>
                        <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2">
                            <option value="">Всі категорії</option>
                            @foreach($categories as $category)
                                @include('admin.categories.options-category', ['category' => $category, 'prefix' => ''])
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('code')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="code" class="block mb-2 font-bold">Код товару</label>
                        <input type="text" name="code" id="code" class="w-full border rounded px-3 py-2" value="{{ old('code') }}">
                    </div>

                    <div class="mb-4">
                        @error('title')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="title" class="block mb-2 font-bold">Назва</label>
                        <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2" value="{{ old('title') }}">
                    </div>

                    <div class="mb-4">
                        <label for="model" class="block mb-2 font-bold">Модель</label>
                        <input type="text" name="model" id="model" class="w-full border rounded px-3 py-2" value="{{ old('model') }}">
                    </div>

                    <div class="mb-4">
                        @error('description')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="description" class="block mb-2 font-bold">Опис товару</label>
                        <textarea name="description" id="description" class="w-full border rounded px-3 py-2 h-32">{{ old('description') }}</textarea>
                    </div>

                    <div id="productVariantsContainer">
                        <div class="productVariant mb-4" id="productVariantTemplate">
                            <div class="mb-4">
                                @error('color_id')
                                <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                                @enderror
                                <label for="color_id" class="block mb-2 font-bold">Колір</label>
                                <select name="productVariant[color][]" id="color_id" class="w-full border rounded px-3 py-2">
                                    <option value="">Всі кольори</option>
                                    @foreach($colors as $color)
                                        <option value="{{ $color->id }}">{{ $color->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                @error('size_id')
                                <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                                @enderror
                                <label for="size_id" class="block mb-2 font-bold">Розмір</label>
                                <select name="productVariant[size][]" id="size_id" class="w-full border rounded px-3 py-2">
                                    <option value="">Всі розміри</option>
                                    @foreach($sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                @error('quantity')
                                <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                                @enderror
                                <label for="quantity" class="block mb-2 font-bold">Кількість</label>
                                <input type="number" name="productVariant[quantity][]" id="quantity" class="w-full border rounded px-3 py-2" value="{{ old('quantity') }}">
                            </div>

                            <div class="text-center mb-4">
                                <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 w-full border" onclick="removeProductVariant(this)">Видалити варіант</button>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 w-full border" onclick="addNewProductVariant()">Додати додатковий колір, розмір та кількість</button>
                    </div>

                    <div class="mb-4">
                        @error('producer_id')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="producer_id" class="block mb-2 font-bold">Виробник</label>
                        <select name="producer_id" id="producer_id" class="w-full border rounded px-3 py-2">
                            <option value="">Всі виробники</option>
                            @foreach($producers as $producer)
                                <option value="{{ $producer->id }}">{{ $producer->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="material_id" class="block mb-2 font-bold">Матеріал</label>
                        <select name="material_id" id="material_id" class="w-full border rounded px-3 py-2">
                            <option value="">Всі матеріали</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="characteristic_id" class="block mb-2 font-bold">Характеристики</label>
                        <select name="characteristic_id" id="characteristic_id" class="w-full border rounded px-3 py-2">
                            <option value="">Всі характеристики</option>
                            @foreach($characteristics as $characteristic)
                                <option value="{{ $characteristic->id }}">Висота: {{ $characteristic->height }}cm Ширина: {{ $characteristic->width }}cm Довжина: {{ $characteristic->length }}cm</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('top_product')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="top_product" class="block mb-2 font-bold">Топ продукт</label>
                        <select name="top_product" id="top_product" class="w-full border rounded px-3 py-2">
                            <option value="0"> Так / Ні </option>
                            <option value="1"> Так </option>
                            <option value="0"> Ні </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('status_id')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="status_id" class="block mb-2 font-bold">Статус товару</label>
                        <select name="status_id" id="status_id" class="w-full border rounded px-3 py-2">
                            <option value="">Всі статуси</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('retail')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="retail" class="block mb-2 font-bold">Роздрібна ціна</label>
                        <input type="text" name="retail" id="retail" class="w-full border rounded px-3 py-2" value="{{ old('retail') }}">
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Створити товар</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function addNewImagesWithAlt(button) {
        const imageContainer = document.getElementById('image_container');
        const imageWithAltDiv = document.createElement('div');
        imageWithAltDiv.classList.add('image_div', 'border', 'border-gray-500', 'rounded', 'p-4', 'mb-4');
        const imageDivCount = document.querySelectorAll('.image_div').length;
        const countImageDiv = imageDivCount + 1;
        imageWithAltDiv.innerHTML = `
            <div class="mb-4">
                @error("additional")
                    <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                @enderror
                <label for="additional[${countImageDiv}][image]" class="block mb-2 font-bold">Додаткова фотографія ${countImageDiv}</label>
                <input type="file" name="additional[${countImageDiv}][image]" id="additional[${countImageDiv}][image]" class="w-full border rounded px-3 py-2">
            </div>

            <div class="w-full grid grid-cols-2 gap-4">
                <div class="mb-4">
                    @error('additional')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                    @enderror
                    <label for="additional[${countImageDiv}][alt]" class="block mb-2 font-bold">Alt для додаткової фотографії</label>
                    <input type="text" name="additional[${countImageDiv}][alt]" id="additional[${countImageDiv}][alt_uk]" class="w-full border rounded px-3 py-2">
                </div>
            </div>
            <div class="text-right">
                <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out" onclick="deleteAdditionalImageWithAlts(this)">Видалити додаткову фотографію та alt</button>
            </div>
        `;
        imageContainer.appendChild(imageWithAltDiv);
    }

    function deleteAdditionalImageWithAlts(button) {
        const imageWithAltDiv = button.closest('.image_div');
        imageWithAltDiv.remove();
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        const productVariantTemplate = document.getElementById('productVariantTemplate');

        window.addNewProductVariant = function () {
            const newVariant = productVariantTemplate.cloneNode(true);
            newVariant.id = '';
            newVariant.classList.remove('hidden');
            document.getElementById('productVariantsContainer').appendChild(newVariant);
        };

        window.removeProductVariant = function (button) {
            const variant = button.closest('.productVariant');
            variant.remove();
        };
    });
</script>
