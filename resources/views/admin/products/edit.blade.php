<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Редагувати товар</h2>
                <form action="{{ route('product.update', $product->id) }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf

                    <div class="border border-gray-500 rounded p-4 mb-4 main_images_container" id="main_images_container">
                        @foreach ($product->getMedia($product->id) as $media)
                            @if ($media->getCustomProperty('main_image') === 1)
                                <div class="main_image_with_alt">
                                    <div class="mb-4">
                                        <input type="hidden" name="main_media_id" value="{{ $media->id }}">
                                        <label for="image_main" class="block mb-2 font-bold">Головна фотографія</label>
                                        <div class="mb-4">
                                            <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="w-1/4">
                                        </div>
                                    </div>

                                    <div class="w-full grid grid-cols-2 gap-4">
                                        <div class="mb-4">
                                            @error('alt_for_main_image')
                                            <span class="text-red-500">{{ htmlspecialchars("Потрібно ввести текст, не більше 255 символів") }}</span>
                                            @enderror
                                            <label for="alt_for_main_image" class="block mb-2 font-bold">Alt для головної фотографії</label>
                                            <input type="text" name="alt_for_main_image" id="alt_for_main_image" class="w-full border rounded px-3 py-2" value="{{ $media->getCustomProperty('alt') }}">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" title="Delete Poster With Alt" onclick="deleteMainImageWithAlts(this, {{ $media->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 transition duration-300 rounded">
                                            Видалити головну фотографію з Alt
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div id="additional_images_container" class="border border-gray-500 rounded p-4 mb-4">
                        <h2 class="mb-3"><b>Додаткові фотографії</b></h2>
                        @foreach ($product->getMedia($product->id) as $media)
                            @if ($media->getCustomProperty('main_image') === 0)
                                <div class="border border-gray-500 rounded p-4 mb-4">
                                    <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="rounded-md w-1/4">
                                    <div class="w-full grid grid-cols-2 gap-4">
                                        <div class="mb-4">
                                            <label for="additional_image[{{$media->id}}]" class="block mb-2 font-bold">Alt для додаткової фотографії</label>
                                            <input type="text" name="additional_image[{{$media->id}}][alt]" id="additional_image[{{$media->id}}]" class="w-full border rounded px-3 py-2" value="{{ $media->getCustomProperty('alt') }}">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out" onclick="deleteAdditionalImageWithAlts(this, {{ $media->id }})">
                                            Видалити додаткову фотографію з Alt
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div id="image_container" class="mb-4"></div>

                    <div class="text-center mb-4">
                        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 w-full border" onclick="addNewImagesWithAlt(this)">Додати додаткову фотографію та Alts</button>
                    </div>

                    <div class="mb-4">
                        @error('category_id')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="category_id" class="block mb-2 font-bold">Категорія</label>
                        <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($category->id == $product->category_id ) selected @endif>{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('code')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="code" class="block mb-2 font-bold">Код товару</label>
                        <input type="text" name="code" id="code" class="w-full border rounded px-3 py-2" value="{{ $product->code }}">
                    </div>

                    <div class="mb-4">
                        @error('title')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="title" class="block mb-2 font-bold">Назва товару</label>
                        <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2" value="{{ $product->title }}">
                    </div>

                    <div class="mb-4">
                        <label for="model" class="block mb-2 font-bold">Модель</label>
                        <input type="text" name="model" id="model" class="w-full border rounded px-3 py-2" value="{{ $product->model }}">
                    </div>

                    <div class="mb-4">
                        @error('description')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="description" class="block mb-2 font-bold">Опис товару</label>
                        <textarea name="description" id="description" class="w-full border rounded px-3 py-2 h-32">{{ $product->description }}</textarea>
                    </div>

                    <div id="productVariantsContainer">
                        @foreach($productVariants as $productVariant)
                            <div class="productVariant mb-4 variant_div">
                                <div class="mb-4">
                                    @error('color_{{$productVariant->id}}')
                                    <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                                    @enderror
                                    <label for="color_{{$productVariant->id}}" class="block mb-2 font-bold">Колір</label>
                                    <select name="productVariant[{{ $productVariant->id }}][color]" id="color_{{$productVariant->id}}" class="w-full border rounded px-3 py-2">
                                        @foreach($colors as $color)
                                            <option value="{{ $color->id }}" @if($productVariant->color_id == $color->id) selected @endif>{{ $color->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    @error('size_{{$productVariant->id}}')
                                    <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                                    @enderror
                                    <label for="size_{{$productVariant->id}}" class="block mb-2 font-bold">Розмір</label>
                                    <select name="productVariant[{{ $productVariant->id }}][size]" id="size_{{$productVariant->id}}" class="w-full border rounded px-3 py-2">
                                        <option value="">Всі розміри</option>
                                        @foreach($sizes as $size)
                                            <option value="{{ $size->id }}" @if($productVariant->size_id == $size->id) selected @endif>{{ $size->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    @error('quantity_{{$productVariant->id}}')
                                    <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                                    @enderror
                                    <label for="quantity_{{$productVariant->id}}" class="block mb-2 font-bold">Кількість</label>
                                    <input type="number" name="productVariant[{{ $productVariant->id }}][quantity]" id="quantity_{{$productVariant->id}}" class="w-full border rounded px-3 py-2" value="{{ $productVariant->quantity }}">
                                </div>

                                <div class="text-center mb-4">
                                    <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 w-full border" onclick="removeProductVariant(this, {{ $productVariant->id }})">Видалити варіант</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mb-4">
                        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 w-full border" onclick="addNewProductVariant()">Додати додатковий колір, розмір та кількість</button>
                    </div>

                    <div class="mb-4">
                        @error('package_id')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="package_id" class="block mb-2 font-bold">К-сть. у пакуванні</label>
                        <select name="package_id" id="package_id" class="w-full border rounded px-3 py-2">
                            @foreach($packages as $package)
                                <option value="{{ $package->id }}" @if($package->id == $product->package_id ) selected @endif>{{ $package->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('producer_id')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="producer_id" class="block mb-2 font-bold">Виробник</label>
                        <select name="producer_id" id="producer_id" class="w-full border rounded px-3 py-2">
                            @foreach($producers as $producer)
                                <option value="{{ $producer->id }}" @if($producer->id == $product->producer_id ) selected @endif>{{ $producer->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="material_id" class="block mb-2 font-bold">Матеріал</label>
                        <select name="material_id" id="material_id" class="w-full border rounded px-3 py-2">
                            <option value="">Всі матеріали</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}" @if($material->id == $product->material_id ) selected @endif>{{ $material->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="characteristic_id" class="block mb-2 font-bold">Характеристики</label>
                        <select name="characteristic_id" id="characteristic_id" class="w-full border rounded px-3 py-2">
                            <option value="">Всі характеристики</option>
                            @foreach($characteristics as $characteristic)
                                <option value="{{ $characteristic->id }}" @if($characteristic->id == $product->characteristic_id ) selected @endif>Height: {{ $characteristic->height }}cm Width: {{ $characteristic->width }}cm Довжина: {{ $characteristic->length }}cm</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('product_promotion')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="product_promotion" class="block mb-2 font-bold">Промоакція</label>
                        <select name="product_promotion" id="product_promotion" class="w-full border rounded px-3 py-2">
                            <option value="0" @if($product->product_promotion == 0 ) selected @endif> Ні </option>
                            <option value="1" @if($product->product_promotion == 1 ) selected @endif> Так </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('top_product')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="top_product" class="block mb-2 font-bold">Топ продукт</label>
                        <select name="top_product" id="top_product" class="w-full border rounded px-3 py-2">
                            <option value="0" @if($product->top_product == 0 ) selected @endif> Ні </option>
                            <option value="1" @if($product->top_product == 1 ) selected @endif> Так </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('rec_product')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="rec_product" class="block mb-2 font-bold">Рекомендований товар</label>
                        <select name="rec_product" id="rec_product" class="w-full border rounded px-3 py-2">
                            <option value="0" @if($product->rec_product == 0 ) selected @endif> Ні </option>
                            <option value="1" @if($product->rec_product == 1 ) selected @endif> Так </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('status_id')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="status_id" class="block mb-2 font-bold">Статус</label>
                        <select name="status_id" id="status_id" class="w-full border rounded px-3 py-2">
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" @if($status->id == $product->status_id ) selected @endif>{{ $status->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    @foreach($product->price()->get() as $price)
                        <div class="mb-4">
                            @error('pair')
                            <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                            @enderror
                            <label for="pair" class="block mb-2 font-bold">Ціна за одну пару</label>
                            <input type="text" name="pair" id="pair" class="w-full border rounded px-3 py-2" value="{{ $price->pair }}">
                        </div>

                        <div class="mb-4">
                            @error('rec_pair')
                            <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                            @enderror
                            <label for="rec_pair" class="block mb-2 font-bold">Рекомендована ціна за одну пару</label>
                            <input type="text" name="rec_pair" id="rec_pair" class="w-full border rounded px-3 py-2" value="{{ $price->rec_pair }}">
                        </div>

                        <div class="mb-4">
                            @error('package')
                            <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                            @enderror
                            <label for="package" class="block mb-2 font-bold">Ціна за опт</label>
                            <input type="text" name="package" id="package" class="w-full border rounded px-3 py-2" value="{{ $price->package }}">
                        </div>

                        <div class="mb-4">
                            @error('rec_package')
                            <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                            @enderror
                            <label for="rec_package" class="block mb-2 font-bold">Рекомендована ціна за опт</label>
                            <input type="text" name="rec_package" id="rec_package" class="w-full border rounded px-3 py-2" value="{{ $price->rec_package }}">
                        </div>

                        <div class="mb-4">
                            @error('retail')
                            <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                            @enderror
                            <label for="retail" class="block mb-2 font-bold">Роздрібна ціна</label>
                            <input type="text" name="retail" id="retail" class="w-full border rounded px-3 py-2" value="{{ $price->retail }}">
                        </div>
                    @endforeach

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Оновити продукт</button>
                    </div>
                </form>
                @if ($product->getMedia($product->id)->slice(1))
                    @foreach ($product->getMedia($product->id) as $media)
                        <form action="{{ route('product.destroyMedia', $media->id) }}" method="POST" id="media_{{ $media->id }}">
                            @csrf
                            @method("DELETE")
                        </form>
                    @endforeach
                @endif
                @foreach ($productVariants as $productVariant)
                    <form action="{{ route('product.destroyProductVariant', $productVariant->id) }}" method="POST" id="variant_{{ $productVariant->id }}">
                        @csrf
                        @method("DELETE")
                    </form>
                @endforeach
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
                <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out" onclick="deleteAdditionalImageWithAlts(this)">Видалити додаткову фотографію з Alts</button>
            </div>
        `;
        imageContainer.appendChild(imageWithAltDiv);
    }

    function deleteAdditionalImageWithAlts(button, mediaId) {
        const imageWithAltsContainer = button.closest('.additional_div');
        if (mediaId) {
            let form_id = '#media_' + mediaId;
            let form = document.querySelector(form_id);

            form.submit();
        }
        imageWithAltsContainer.remove();
    }

    function deleteMainImageWithAlts(button, mediaId) {
        const mainImageWithAlts = button.closest('.main_image_with_alt');
        const mainImageWithAltsContainer = document.getElementById('main_images_container');
        if (mediaId) {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'deleted_main_image';
            hiddenInput.value = mediaId;
            mainImageWithAltsContainer.appendChild(hiddenInput);
        }
        mainImageWithAlts.remove();

        const mainImage = document.createElement('div');
        mainImage.classList.add('main_image_with_alts');
        mainImage.innerHTML = `
            <div class="mb-4">
                @error('main_image')
                        <span class="text-red-500">Треба обов'язково вибрати картинку</span>
                @enderror
                        <label for="main_image" class="block mb-2 font-bold">Головна фотографія</label>
                        <input type="file" name="main_image" id="main_image" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="w-full grid grid-cols-2 gap-4">
                        <div class="mb-4">
                @error('alt_for_main_image')
                        <span class="text-red-500">Потрібно ввести текст, не більше 255 символів</span>
                @enderror
                        <label for="alt_for_main_image" class="block mb-2 font-bold">Alt для головної фотографії</label>
                        <input type="text" name="alt_for_main_image" id="alt_for_main_image" class="w-full border rounded px-3 py-2" value="">
                    </div>
                </div>
            `;
        mainImageWithAltsContainer.appendChild(mainImage);
    }

    function addNewProductVariant(button) {
        const variantContainer = document.getElementById('productVariantsContainer');
        const variantDiv = document.createElement('div');
        variantDiv.classList.add('variant_div');
        const variantDivCount = document.querySelectorAll('.variant_div').length;
        const countVariantDiv = variantDivCount + 1;
        variantDiv.innerHTML = `
            <div class="productVariant mb-4">
                <div class="mb-4">
                    <label for="new_color_${countVariantDiv}" class="block mb-2 font-bold">Колір</label>
                    <select name="newProductVariant[${countVariantDiv}][color]" id="new_color_${countVariantDiv}" class="w-full border rounded px-3 py-2">
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="new_size_${countVariantDiv}" class="block mb-2 font-bold">Розмір</label>
                    <select name="newProductVariant[${countVariantDiv}][size]" id="new_size_${countVariantDiv}" class="w-full border rounded px-3 py-2">
                        @foreach($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="new_quantity_${countVariantDiv}" class="block mb-2 font-bold">Кількість</label>
                    <input type="number" name="newProductVariant[${countVariantDiv}][quantity]" id="new_quantity_${countVariantDiv}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="text-center mb-4">
                    <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 w-full border" onclick="removeProductVariant(this)">Видалити варіант</button>
                </div>
            </div>
        `;
        variantContainer.appendChild(variantDiv);
    }

    function removeProductVariant(button, variantId) {
        const variantContainer = button.closest('.variant_div');
        if (variantId) {
            let form_id = '#variant_' + variantId;
            let form = document.querySelector(form_id);

            form.submit();
        }
        variantContainer.remove();
    }
</script>
