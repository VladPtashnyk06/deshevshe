<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Додати топ товар</h2>
                <div class="text-center mb-4">
                    <a href="{{ route('top-product.index') }}" class="bg-gray-600 hover:bg-gray-700 block text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Назад</a>
                </div>
                <div class="text-center mb-4">
                    <form action="{{ route('top-product.create') }}" method="GET" style="display: flex; align-items: center; justify-content: center;">
                        <div class="mb-4 mr-4" style="flex: 1;">
                            <label for="code" class="block mb-2 font-bold">Код товару:</label>
                            <input type="text" name="code" id="code" class="w-full" value="{{ !empty(request()->input('code')) ? request()->input('code') : '' }}">
                        </div>
                        <div class="mb-4" style="flex: 1;">
                            <label for="title" class="block mb-2 font-bold">Назва товару:</label>
                            <input type="text" name="title" id="title" class="w-full" value="{{ !empty(request()->input('title')) ? request()->input('title') : '' }}">
                        </div>
                        <div class="mb-4 ml-4" style="flex: 1;">
                            <label for="producer_id" class="block mb-2 font-bold">Виробники:</label>
                            <select name="producer_id" id="producer_id" class="w-full border rounded px-3 py-2">
                                <option value="">Усі виробники</option>
                                @foreach ($producers as $producer)
                                    <option value="{{ $producer->id }}" @if(request()->input('producer_id') == $producer->id) selected @endif>{{ $producer->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4 ml-4" style="flex: 1;">
                            <label for="category_id" class="block mb-2 font-bold">Категорії:</label>
                            <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2">
                                <option value="">Усі категорії</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if(request()->input('category_id') == $category->id) selected @endif>{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ml-2 mb-4">
                            <div class="mt-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">Застосувати фільтри</button>
                                <button type="button" onclick="window.location='{{ route('promotional.create') }}'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border ml-2">Очистити фільтри</button>
                            </div>
                        </div>
                    </form>
                </div>
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
                        <th class="p-2 text-lg">Роздрібна ціна</th>
                        <th class="p-2 text-lg">Дії</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                    <img style="max-height: 80px;" alt="{{ $product->title }}" src="{{ asset('storage/'. $product->img_path) }}">
                                </td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->code }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->category->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->brand->title ?? 'Не вказанно' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->sex->title ?? 'Не вказанно' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->season->title ?? 'Не вказанно' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->producer->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->product_promotion == 0 ? 'Ні' : 'Так' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->price->retail ?? 'Не вказанно' }}</td>
                                <td class="px-6 py-4 text-right" style="vertical-align: top;">
                                    <form action="{{ route('top-product.store', $product->id) }}" method="post">
                                        @csrf

                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">Додати</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
