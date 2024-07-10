<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Редагувати товар</h2>
                <form action="{{ route('product.update', $product->id) }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf

                    <div class="border border-gray-500 rounded p-4 mb-4 main_images_container" id="main_images_container">
                        @if($product->hasMedia('size_chart_'.$product->id))
                            @foreach ($product->getMedia('size_chart_'.$product->id) as $media)
                                <div class="size_chart_div">
                                    <div class="mb-4">
                                        <input type="hidden" name="main_media_id" value="{{ $media->id }}">
                                        <label for="size_chart_img" class="block mb-2 font-bold">Фотографія розмірної сітки</label>
                                        <div class="mb-4">
                                            <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}">
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button type="button" onclick="replaceTheSizeChartImage(this, {{ $media->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 transition duration-300 rounded">
                                            Замінити фотографію розмірної сітки
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="mb-4">
                                @error("size_chart_img")
                                    <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                                @enderror
                                <label for="size_chart_img" class="block mb-2 font-bold">Фотографія розмірної сітки</label>
                                <input type="file" name="size_chart_img" id="size_chart_img" class="w-full border rounded px-3 py-2">
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        @error('description')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="description" class="block mb-2 font-bold">Опис товару</label>
                        <textarea name="description" id="description" class="w-full border rounded px-3 py-2 h-32">{{ $product->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        @error('advantages')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="advantages" class="block mb-2 font-bold">Переваги</label>
                        <textarea name="advantages" id="advantages" class="w-full border rounded px-3 py-2 h-32">{{ $product->advantages }}</textarea>
                    </div>

                    <div class="mb-4">
                        @error('outfit')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="outfit" class="block mb-2 font-bold">Створюй образ</label>
                        <textarea name="outfit" id="outfit" class="w-full border rounded px-3 py-2 h-32">{{ $product->outfit }}</textarea>
                    </div>

                    <div class="mb-4">
                        @error('measurements')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="measurements" class="block mb-2 font-bold">Параметри фотомоделі</label>
                        <textarea name="measurements" id="measurements" class="w-full border rounded px-3 py-2 h-32">{{ $product->measurements }}</textarea>
                    </div>

                    <div class="w-full flex grid grid-cols-2">
                        <div class="text-center mb-4 mr-2">
                            <a href="{{ route('product.index') }}" class="bg-gray-600 hover:bg-gray-700 block text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Назад</a>
                        </div>
                        <div class="text-center mb-4">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Оновити продукт</button>
                        </div>
                    </div>
                </form>
                @if ($product->getMedia('size_chart_'.$product->id)->slice(1))
                    @foreach ($product->getMedia('size_chart_'.$product->id) as $media)
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
    function replaceTheSizeChartImage(button, mediaId) {
        const sizeChartContainer = button.closest('.size_chart_div');
        if (mediaId) {
            let form_id = '#media_' + mediaId;
            let form = document.querySelector(form_id);

            form.submit();
        }
        sizeChartContainer.remove();
    }
</script>
