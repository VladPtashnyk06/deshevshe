<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Create Product</h2>
                <form action="{{ route('product.store') }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <div class="mb-4">
                            @error('main_image')
                            <span class="text-red-500">{{ htmlspecialchars("You must select an image") }}</span>
                            @enderror
                            <label for="main_image" class="block mb-2 font-bold">Main Image</label>
                            <input type="file" name="main_image" id="main_image" class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="w-full grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                @error('alt_for_main_image')
                                <span class="text-red-500">{{ htmlspecialchars("Please enter a text, not more than 255 characters") }}</span>
                                @enderror
                                <label for="alt_for_main_image" class="block mb-2 font-bold">Alt For Main Image</label>
                                <input type="text" name="alt_for_main_image" id="alt_for_main_image" class="w-full border rounded px-3 py-2" value="{{ old('alt_for_main_image') }}">
                            </div>
                        </div>
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
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('code')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="code" class="block mb-2 font-bold">Code</label>
                        <input type="text" name="code" id="code" class="w-full border rounded px-3 py-2" value="{{ old('code') }}">
                    </div>

                    <div class="mb-4">
                        @error('title')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="title" class="block mb-2 font-bold">Title</label>
                        <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2" value="{{ old('title') }}">
                    </div>

                    <div class="mb-4">
                        @error('quantity')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="quantity" class="block mb-2 font-bold">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="w-full border rounded px-3 py-2" value="{{ old('quantity') }}">
                    </div>

                    <div class="mb-4">
                        <label for="model" class="block mb-2 font-bold">Model</label>
                        <input type="text" name="model" id="model" class="w-full border rounded px-3 py-2" value="{{ old('model') }}">
                    </div>

                    <div class="mb-4">
                        @error('description')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required and unique") }}</span>
                        @enderror
                        <label for="description" class="block mb-2 font-bold">Description in Ukrainian</label>
                        <textarea name="description" id="description" class="w-full border rounded px-3 py-2 h-32">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        @error('color_id')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="color_id" class="block mb-2 font-bold">Color</label>
                        <select name="color_id" id="color_id" class="w-full border rounded px-3 py-2">
                            <option value="">All Color</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('size_id')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="size_id" class="block mb-2 font-bold">Size</label>
                        <select name="size_id" id="size_id" class="w-full border rounded px-3 py-2">
                            <option value="">All Sizes</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('package_id')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="package_id" class="block mb-2 font-bold">Package</label>
                        <select name="package_id" id="package_id" class="w-full border rounded px-3 py-2">
                            <option value="">All Packages</option>
                            @foreach($packages as $package)
                                <option value="{{ $package->id }}">{{ $package->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('producer_id')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="producer_id" class="block mb-2 font-bold">Producer</label>
                        <select name="producer_id" id="producer_id" class="w-full border rounded px-3 py-2">
                            <option value="">All Producers</option>
                            @foreach($producers as $producer)
                                <option value="{{ $producer->id }}">{{ $producer->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="material_id" class="block mb-2 font-bold">Material</label>
                        <select name="material_id" id="material_id" class="w-full border rounded px-3 py-2">
                            <option value="">All Materials</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="characteristic_id" class="block mb-2 font-bold">Characteristic</label>
                        <select name="characteristic_id" id="characteristic_id" class="w-full border rounded px-3 py-2">
                            <option value="">All Characteristics</option>
                            @foreach($characteristics as $characteristic)
                                <option value="{{ $characteristic->id }}">Height: {{ $characteristic->height }}cm Width: {{ $characteristic->width }}cm</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('product_promotion')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="product_promotion" class="block mb-2 font-bold">Product Promotion</label>
                        <select name="product_promotion" id="product_promotion" class="w-full border rounded px-3 py-2">
                            <option value="0"> Yes / No </option>
                            <option value="1"> Yes </option>
                            <option value="0"> No </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('top_product')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="top_product" class="block mb-2 font-bold">Top Product </label>
                        <select name="top_product" id="top_product" class="w-full border rounded px-3 py-2">
                            <option value="0"> Yes / No </option>
                            <option value="1"> Yes </option>
                            <option value="0"> No </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('rec_product')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="rec_product" class="block mb-2 font-bold">Rec Product</label>
                        <select name="rec_product" id="rec_product" class="w-full border rounded px-3 py-2">
                            <option value="0"> Yes / No </option>
                            <option value="1"> Yes </option>
                            <option value="0"> No </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('status_id')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="status_id" class="block mb-2 font-bold">Status</label>
                        <select name="status_id" id="status_id" class="w-full border rounded px-3 py-2">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('pair')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="pair" class="block mb-2 font-bold">Price Pair</label>
                        <input type="text" name="pair" id="pair" class="w-full border rounded px-3 py-2" value="{{ old('pair') }}">
                    </div>

                    <div class="mb-4">
                        @error('rec_pair')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="rec_pair" class="block mb-2 font-bold">Price Rec Pair</label>
                        <input type="text" name="rec_pair" id="rec_pair" class="w-full border rounded px-3 py-2" value="{{ old('rec_pair') }}">
                    </div>

                    <div class="mb-4">
                        @error('package')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="package" class="block mb-2 font-bold">Price Package</label>
                        <input type="text" name="package" id="package" class="w-full border rounded px-3 py-2" value="{{ old('package') }}">
                    </div>

                    <div class="mb-4">
                        @error('rec_package')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="rec_package" class="block mb-2 font-bold">Price Rec Package</label>
                        <input type="text" name="rec_package" id="rec_package" class="w-full border rounded px-3 py-2" value="{{ old('rec_package') }}">
                    </div>

                    <div class="mb-4">
                        @error('retail')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required") }}</span>
                        @enderror
                        <label for="retail" class="block mb-2 font-bold">Price Retail</label>
                        <input type="text" name="retail" id="retail" class="w-full border rounded px-3 py-2" value="{{ old('retail') }}">
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Create Product</button>
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

    function deleteAdditionalImageWithAlts(button) {
        const imageWithAltDiv = button.closest('.image_div');
        imageWithAltDiv.remove();
    }
</script>
