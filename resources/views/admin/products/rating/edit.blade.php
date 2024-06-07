<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 114rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Рейтинг товару</h1>
                    <table class="w-full mb-5">
                        <thead>
                        <tr class="text-center border-b-2 border-gray-700">
                            <th class="p-2 text-lg">Зображення</th>
                            <th class="p-2 text-lg">Код товару</th>
                            <th class="p-2 text-lg">Назва товару</th>
                            <th class="p-2 text-lg">Категорія</th>
                            <th class="p-2 text-lg">Рейтинг</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center odd:bg-gray-200">
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                @foreach($product->getMedia($product->id) as $media)
                                    @if($media->getCustomProperty('main_image') === 1)
                                        <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-16 w-auto rounded-md object-cover">
                                    @endif
                                @endforeach
                            </td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->code }}</td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->title }}</td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->category->title }}</td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->rating }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <h1 class="text-2xl font-semibold mb-2 text-center">Редагувати рейтинг товару</h1>

                    <form action="{{ route('product.updateRatingProduct', $product->id) }}" method="post">
                        @csrf

                        <div class="mb-4">
                            <label for="rating" class="block mb-2 font-bold">Рейтинг товару</label>
                            <input type="number" min="1" max="5" name="rating" id="rating" class="w-full border rounded px-3 py-2" value="{{ $product->rating }}">
                        </div>
                        <div>
                            <div class="text-center mb-4">
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Відредагувати рейтинг товару</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
