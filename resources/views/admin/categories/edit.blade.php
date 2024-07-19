<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4 text-center">Редагувати категорію</h2>
                <form action="{{ route('category.update', $category->id) }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="border border-gray-500 rounded p-4 mb-4 main_images_container" id="main_images_container">
                        @if($category->getMedia('category'.$category->id)->count() == 1)
                            @foreach ($category->getMedia('category'.$category->id) as $media)
                                <div class="main_image_with_alt">
                                    <div class="mb-4">
                                        <input type="hidden" name="main_media_id" value="{{ $media->id }}">
                                        <label for="image_main" class="block mb-2 font-bold">Фотографія категорії</label>
                                        <div class="mb-4">
                                            <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="w-1/4">
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button type="button" title="Delete Poster With Alt" onclick="deleteMainImageWithAlts(this, {{ $media->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 transition duration-300 rounded">
                                            Видалити головну фотографію з Alt
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="mb-4">
                                @error('main_image')
                                <span class="text-red-500">{{ htmlspecialchars("Ви повинні вибрати фотографію") }}</span>
                                @enderror
                                <label for="main_image" class="block mb-2 font-bold">Головна фотографія</label>
                                <input type="file" name="main_image" id="main_image" class="w-full border rounded px-3 py-2">
                            </div>

                            <div class="w-full grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    @error('alt')
                                    <span class="text-red-500">{{ htmlspecialchars("Будь ласка, не більше 255 символів") }}</span>
                                    @enderror
                                    <label for="alt" class="block mb-2 font-bold">Alt для головної фотографії</label>
                                    <input type="text" name="alt" id="alt" class="w-full border rounded px-3 py-2" value="{{ old('alt') }}">
                                </div>
                            </div>
                        @endif
                    </div>

                    <div id="image_container" class="mb-4"></div>

                    <div class="mb-4">
                        @error('id')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле обов'язкове і унікальне") }}</span>
                        @enderror
                        <label for="id" class="block mb-2 font-bold">Id</label>
                        <input type="number" name="id" id="id" class="w-full border rounded px-3 py-2" value="{{ $category->id }}">
                    </div>

                    <div class="mb-4">
                        <label for="parent_id" class="block mb-2 font-bold">Батьківська категорія</label>
                        <select name="parent_id" id="parent_id" class="w-full border rounded px-3 py-2">
                            <option value="">Без батьківської категорії</option>
                            @foreach($categories as $cat)
                                @include('admin.categories.options-category-edit', ['cat' => $cat, 'category' => $category, 'prefix' => ''])
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('title')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле обов'язкове і унікальне") }}</span>
                        @enderror
                        <label for="title" class="block mb-2 font-bold">Категорія</label>
                        <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2" value="{{ $category->title }}">
                    </div>

                    <div class="mb-4">
                        @error('level')
                        <span class="text-red-500">{{ htmlspecialchars($message) }}</span>
                        @enderror
                        <label for="level" class="block mb-2 font-bold">Порядок сортування</label>
                        <input type="text" name="level" id="level" class="w-full border rounded px-3 py-2" value="{{ $category->level }}">
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Оновити категорію</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
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
                <label for="main_image" class="block mb-2 font-bold">Фотографія категорії</label>
                <input type="file" name="main_image" id="main_image" class="w-full border rounded px-3 py-2">
            </div>
</div>
`;
        mainImageWithAltsContainer.appendChild(mainImage);
    }
</script>
