<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Edit Product</h2>
                <form action="{{ route('product.update', $product->id) }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf

                    <div class="border border-gray-500 rounded p-4 mb-4 main_images_container" id="main_images_container">
                        @foreach ($product->getMedia($product->id) as $media)
                            @if ($media->getCustomProperty('main_image') === 1)
                                <div class="main_image_with_alt">
                                    <div class="mb-4">
                                        <input type="hidden" name="main_media_id" value="{{ $media->id }}">
                                        <label for="image_main" class="block mb-2 font-bold">Main Image</label>
                                        <div class="mb-4">
                                            <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="w-1/4">
                                        </div>
                                    </div>

                                    <div class="w-full grid grid-cols-2 gap-4">
                                        <div class="mb-4">
                                            @error('alt_for_main_image')
                                            <span class="text-red-500">{{ htmlspecialchars("Потрібно ввести текст, не більше 255 символів") }}</span>
                                            @enderror
                                            <label for="alt_for_main_image" class="block mb-2 font-bold">Alt For Main Image</label>
                                            <input type="text" name="alt_for_main_image" id="alt_for_main_image" class="w-full border rounded px-3 py-2" value="{{ $media->getCustomProperty('alt') }}">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" title="Delete Poster With Alt" onclick="deleteMainImageWithAlts(this, {{ $media->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 transition duration-300 rounded">
                                            Delete Poster With Alt
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div id="additional_images_container" class="border border-gray-500 rounded p-4 mb-4">
                        <h2 class="mb-3"><b>Additional Images</b></h2>
                        @foreach ($product->getMedia($product->id) as $media)
                            @if ($media->getCustomProperty('main_image') === 0)
                                <div class="border border-gray-500 rounded p-4 mb-4">
                                    <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="rounded-md w-1/4">
                                    <div class="w-full grid grid-cols-2 gap-4">
                                        <div class="mb-4">
                                            <label for="additional_image[{{$media->id}}]" class="block mb-2 font-bold">Alt For Additional Photo</label>
                                            <input type="text" name="additional_image[{{$media->id}}][alt]" id="additional_image[{{$media->id}}]" class="w-full border rounded px-3 py-2" value="{{ $media->getCustomProperty('alt') }}">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out" onclick="deleteAdditionalImageWithAlts(this, {{ $media->id }})">
                                            Delete Additional Photo with Alt
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div id="image_container" class="mb-4"></div>

                    <div class="text-center mb-4">
                        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 w-full border" onclick="addNewImagesWithAlt(this)">Add Additional Image and Their Alts</button>
                    </div>

                    <div class="mb-4">
                        @error('category_id')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="category_id" class="block mb-2 font-bold">Category</label>
                        <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($category->id == $product->category_id ) selected @endif>{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('code')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="code" class="block mb-2 font-bold">Code</label>
                        <input type="text" name="code" id="code" class="w-full border rounded px-3 py-2" value="{{ $product->code }}">
                    </div>

                    <div class="mb-4">
                        @error('title')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="title" class="block mb-2 font-bold">Title</label>
                        <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2" value="{{ $product->title }}">
                    </div>

                    <div class="mb-4">
                        @error('quantity')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="quantity" class="block mb-2 font-bold">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="w-full border rounded px-3 py-2" value="{{ $product->quantity }}">
                    </div>

                    <div class="mb-4">
                        <label for="model" class="block mb-2 font-bold">Model</label>
                        <input type="text" name="model" id="model" class="w-full border rounded px-3 py-2" value="{{ $product->model }}">
                    </div>

                    <div class="mb-4">
                        @error('description')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required and unique") }}</span>
                        @enderror
                        <label for="description" class="block mb-2 font-bold">Description in Ukrainian</label>
                        <textarea name="description" id="description" class="w-full border rounded px-3 py-2 h-32">{{ $product->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        @error('color_id')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="color_id" class="block mb-2 font-bold">Color</label>
                        <select name="color_id" id="color_id" class="w-full border rounded px-3 py-2">
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}" @if($color->id == $product->color_id ) selected @endif>{{ $color->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('size_id')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="size_id" class="block mb-2 font-bold">Size</label>
                        <select name="size_id" id="size_id" class="w-full border rounded px-3 py-2">
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}" @if($size->id == $product->size_id ) selected @endif>{{ $size->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('package_id')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="package_id" class="block mb-2 font-bold">Package</label>
                        <select name="package_id" id="package_id" class="w-full border rounded px-3 py-2">
                            @foreach($packages as $package)
                                <option value="{{ $package->id }}" @if($package->id == $product->package_id ) selected @endif>{{ $package->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('producer_id')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="producer_id" class="block mb-2 font-bold">Producer</label>
                        <select name="producer_id" id="producer_id" class="w-full border rounded px-3 py-2">
                            @foreach($producers as $producer)
                                <option value="{{ $producer->id }}" @if($producer->id == $product->producer_id ) selected @endif>{{ $producer->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="material_id" class="block mb-2 font-bold">Material</label>
                        <select name="material_id" id="material_id" class="w-full border rounded px-3 py-2">
                            <option value="">All Materials</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}" @if($material->id == $product->material_id ) selected @endif>{{ $material->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="characteristic_id" class="block mb-2 font-bold">Characteristic</label>
                        <select name="characteristic_id" id="characteristic_id" class="w-full border rounded px-3 py-2">
                            <option value="">All Characteristics</option>
                            @foreach($characteristics as $characteristic)
                                <option value="{{ $characteristic->id }}" @if($characteristic->id == $product->characteristic_id ) selected @endif>Height: {{ $characteristic->height }}cm Width: {{ $characteristic->width }}cm</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('product_promotion')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="product_promotion" class="block mb-2 font-bold">Product Promotion</label>
                        <select name="product_promotion" id="product_promotion" class="w-full border rounded px-3 py-2">
                            <option value="0" @if($product->product_promotion == 0 ) selected @endif> No </option>
                            <option value="1" @if($product->product_promotion == 1 ) selected @endif> Yes </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('top_product')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="top_product" class="block mb-2 font-bold">Top Product </label>
                        <select name="top_product" id="top_product" class="w-full border rounded px-3 py-2">
                            <option value="0" @if($product->top_product == 0 ) selected @endif> No </option>
                            <option value="1" @if($product->top_product == 1 ) selected @endif> Yes </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('rec_product')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="rec_product" class="block mb-2 font-bold">Rec Product</label>
                        <select name="rec_product" id="rec_product" class="w-full border rounded px-3 py-2">
                            <option value="0" @if($product->rec_product == 0 ) selected @endif> No </option>
                            <option value="1" @if($product->rec_product == 1 ) selected @endif> Yes </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('status_id')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="status_id" class="block mb-2 font-bold">Status</label>
                        <select name="status_id" id="status_id" class="w-full border rounded px-3 py-2">
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" @if($status->id == $product->status_id ) selected @endif>{{ $status->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Update Product</button>
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
                    <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                @enderror
                <label for="additional[${countImageDiv}][image]" class="block mb-2 font-bold">Additional Image ${countImageDiv}</label>
                <input type="file" name="additional[${countImageDiv}][image]" id="additional[${countImageDiv}][image]" class="w-full border rounded px-3 py-2">
            </div>

            <div class="w-full grid grid-cols-2 gap-4">
                <div class="mb-4">
                    @error('additional')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                    @enderror
                    <label for="additional[${countImageDiv}][alt]" class="block mb-2 font-bold">Alt For Additional Image</label>
                    <input type="text" name="additional[${countImageDiv}][alt]" id="additional[${countImageDiv}][alt_uk]" class="w-full border rounded px-3 py-2">
                </div>
            </div>
            <div class="text-right">
                <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out" onclick="deleteAdditionalImageWithAlts(this)">Delete Image and Alts</button>
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
                        <label for="main_image" class="block mb-2 font-bold">Main Image</label>
                        <input type="file" name="main_image" id="main_image" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="w-full grid grid-cols-2 gap-4">
                        <div class="mb-4">
                @error('alt_for_main_image')
                        <span class="text-red-500">Потрібно ввести текст, не більше 255 символів</span>
                @enderror
                        <label for="alt_for_main_image" class="block mb-2 font-bold">Alt For Main Image</label>
                        <input type="text" name="alt_for_main_image" id="alt_for_main_image" class="w-full border rounded px-3 py-2" value="">
                    </div>
                </div>
            `;
        mainImageWithAltsContainer.appendChild(mainImage);
    }
</script>
