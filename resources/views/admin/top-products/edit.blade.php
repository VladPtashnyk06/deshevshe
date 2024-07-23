<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 95rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Відредагувати топ товар</h1>
                    <table class="w-full mb-5">
                        <thead>
                        <tr class="text-center border-b-2 border-gray-700">
                            <th class="p-2 text-lg">Зображення</th>
                            <th class="p-2 text-lg">Код товару</th>
                            <th class="p-2 text-lg">Назва товару</th>
                            <th class="p-2 text-lg">Ціна</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center odd:bg-gray-200">
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                <img style="max-height: 80px;" alt="{{ $topProduct->product->title }}" src="{{ asset('storage/'. $topProduct->product->img_path) }}">
                            </td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $topProduct->product->code }}</td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $topProduct->product->title }}</td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $topProduct->product->price->retail }} UAH</td>
                        </tr>
                        </tbody>
                    </table>
                    <form action="{{ route('top-product.update', $topProduct->id) }}" method="post">
                        @csrf
                        <div>
                            <div class="mb-4">
                                <label for="count_purchased" class="block mb-2 font-bold">Кількість замовлень:</label>
                                <input type="number" class="w-full border rounded px-3 py-2" min="0" name="count_purchased" id="count_purchased" value="{{ $topProduct->count_purchased }}">
                            </div>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full">
                            Відредагувати кількість замовлень
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
