<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 114rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Головний товар</h1>
                    <table class="w-full mb-5">
                        <thead>
                        <tr class="text-center border-b-2 border-gray-700">
                            <th class="p-2 text-lg">Зображення</th>
                            <th class="p-2 text-lg">Код товару</th>
                            <th class="p-2 text-lg">Назва товару</th>
                            <th class="p-2 text-lg">Категорія</th>
                            <th class="p-2 text-lg">Бренд</th>
                            <th class="p-2 text-lg">Стать</th>
                            <th class="p-2 text-lg">Сезон</th>
                            <th class="p-2 text-lg">Виробник</th>
                            <th class="p-2 text-lg">Акційний</th>
                            <th class="p-2 text-lg">Топ продукт</th>
                            <th class="p-2 text-lg">Роздрібна ціна</th>
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
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->brand->title ?? 'Не вказанно' }}</td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->sex->title ?? 'Не вказанно' }}</td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->season->title ?? 'Не вказанно' }}</td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->producer->title }}</td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->product_promotion == 0 ? 'Ні' : 'Так' }}</td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->top_product == 0 ? 'Ні' : 'Так' }}</td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->price->retail }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="w-full flex grid grid-cols-2">
                        <div class="text-center mb-4 mr-2">
                            <a href="{{ route('product.index') }}" class="bg-gray-600 hover:bg-gray-700 block text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Назад</a>
                        </div>
                        <div class="text-center mb-4">
                            <a href="{{ route('related-product.create', $product->id) }}" class="bg-green-600 hover:bg-green-700 block text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Додати супутній товар</a>
                        </div>
                    </div>

                    <h1 class="text-2xl font-semibold mb-2 text-center">Супутні товари</h1>
                    <table class="w-full mb-5">
                        <thead>
                        <tr class="text-center border-b-2 border-gray-700">
                            <th class="p-2 text-lg">Зображення</th>
                            <th class="p-2 text-lg">Код товару</th>
                            <th class="p-2 text-lg">Назва товару</th>
                            <th class="p-2 text-lg">Категорія</th>
                            <th class="p-2 text-lg">Бренд</th>
                            <th class="p-2 text-lg">Стать</th>
                            <th class="p-2 text-lg">Сезон</th>
                            <th class="p-2 text-lg">Виробник</th>
                            <th class="p-2 text-lg">Акційний</th>
                            <th class="p-2 text-lg">Топ продукт</th>
                            <th class="p-2 text-lg">Роздрібна ціна</th>
                            <th class="p-2 text-lg">Дії</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($relatedProducts as $relatedProduct)
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                    @foreach($relatedProduct->relatedProduct->getMedia($relatedProduct->relatedProduct->id) as $media)
                                        @if($media->getCustomProperty('main_image') === 1)
                                            <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-16 w-auto rounded-md object-cover">
                                        @endif
                                    @endforeach
                                </td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $relatedProduct->relatedProduct->code }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $relatedProduct->relatedProduct->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $relatedProduct->relatedProduct->category->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->brand->title ?? 'Не вказанно' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->sex->title ?? 'Не вказанно' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->season->title ?? 'Не вказанно' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $relatedProduct->relatedProduct->producer->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $relatedProduct->relatedProduct->product_promotion == 0 ? 'Ні' : 'Так' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $relatedProduct->relatedProduct->top_product == 0 ? 'Ні' : 'Так' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $relatedProduct->relatedProduct->price->retail }}</td>
                                <td class="px-6 py-4 text-right" style="vertical-align: top;">
                                    <div class="mr-4">
                                        <form action="{{ route('related-product.delete', $relatedProduct->id) }}" method="POST" class="mb-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn bg-red-500 hover:bg-red-700 text-white">Видалити</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
