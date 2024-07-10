<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 114rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Продукт</h1>
                    <div class="text-center mb-4">
                        <a href="{{ route('product.index') }}" class="bg-gray-600 hover:bg-gray-700 block text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Назад</a>
                    </div>
                    <table class="w-full mb-5">
                        <thead>
                        <tr class="text-center border-b-2 border-gray-700">
                            <th class="p-2 text-lg">Зображення</th>
                            <th class="p-2 text-lg">Код товару</th>
                            <th class="p-2 text-lg">Назва товару</th>
                            <th class="p-2 text-lg">Категорія</th>
                            <th class="p-2 text-lg">Бренд</th>
                            <th class="p-2 text-lg">Стиль</th>
                            <th class="p-2 text-lg">Фасон</th>
                            <th class="p-2 text-lg">Сезон</th>
                            <th class="p-2 text-lg">Стать</th>
                            <th class="p-2 text-lg">Склад</th>
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
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->style->title ?? 'Не вказанно' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->fashion->title ?? 'Не вказанно' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->season->title ?? 'Не вказанно' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->sex->title ?? 'Не вказанно' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->fabricComposition->title ?? 'Не вказанно' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->producer->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->product_promotion == 0 ? 'Ні' : 'Так' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->top_product == 0 ? 'Ні' : 'Так' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->price->retail }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="w-full flex grid grid-cols-2">
                        <div class="mr-4">
                            <div>
                                <h1 class="text-2xl font-semibold mb-2 text-center">Варіанти</h1>
                                <table class="w-full mb-5">
                                    <thead>
                                        <tr class="text-center border-b-2 border-gray-700">
                                            <th class="p-2 text-lg">Колір</th>
                                            <th class="p-2 text-lg">Розмір</th>
                                            <th class="p-2 text-lg">Кількість</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($product->productVariants()->get() as $productVariant)
                                        <tr class="text-center odd:bg-gray-200">
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $productVariant->color->title }}</td>
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $productVariant->size->title }}</td>
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $productVariant->quantity }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <h1 class="text-2xl font-semibold mb-2 text-center">Характеристики</h1>
                                <table class="w-full mb-5">
                                    <thead>
                                        <tr class="text-center border-b-2 border-gray-700">
                                            <th class="p-2 text-lg">Ширина</th>
                                            <th class="p-2 text-lg">Довжина</th>
                                            <th class="p-2 text-lg">Висота</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($product->characteristic()->get() as $characteristic)
                                        <tr class="text-center odd:bg-gray-200">
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $characteristic->width ?? 'Не вказанно' }}</td>
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $characteristic->length ?? 'Не вказанно' }}</td>
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $characteristic->height ?? 'Не вказанно' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold mb-2 text-center">Деталі</h1>
                            <div>
                                <table class="w-full mb-5">
                                    <thead>
                                    <tr class="text-center border-b-2 border-gray-700">
                                        <th class="p-2 text-lg">Опис</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-left odd:bg-gray-200">
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{!! $description !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <table class="w-full mb-5">
                                    <thead>
                                    <tr class="text-center border-b-2 border-gray-700">
                                        <th class="p-2 text-lg">Переваги</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-left odd:bg-gray-200">
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                                @foreach($advantagesArray as $advantage)
                                                    - {{ $advantage }} <br>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <table class="w-full mb-5">
                                    <thead>
                                    <tr class="text-center border-b-2 border-gray-700">
                                        <th class="p-2 text-lg">Створюйте образ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-left odd:bg-gray-200">
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                                @foreach($outfitsArray as $outfit)
                                                    - {{ $outfit }} <br>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <table class="w-full mb-5">
                                    <thead>
                                    <tr class="text-center border-b-2 border-gray-700">
                                        <th class="p-2 text-lg">Параметри фотомоделі</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-left odd:bg-gray-200">
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                                @foreach($measurementsArray as $measurement)
                                                    - {{ $measurement }} <br>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
