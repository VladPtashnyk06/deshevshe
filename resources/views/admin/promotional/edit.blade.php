<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 95rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Відредагувати акційний товар</h1>
                    <form action="{{ route('promotional.update', $promotionalProduct['promotional_id']) }}" method="post">
                        @csrf

                        <table class="w-full mb-5">
                            <thead>
                            <tr class="text-center border-b-2 border-gray-700">
                                <th class="p-2 text-lg">Зображення</th>
                                <th class="p-2 text-lg">Код товару</th>
                                <th class="p-2 text-lg">Назва товару</th>
                                <th class="p-2 text-lg">Колір</th>
                                <th class="p-2 text-lg">Розмір</th>
                                <th class="p-2 text-lg">Ціна</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                    @foreach($promotionalProduct['product']->getMedia($promotionalProduct['product']->id) as $media)
                                        @if($media->getCustomProperty('main_image') === 1)
                                            <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-16 w-auto rounded-md object-cover">
                                        @endif
                                    @endforeach
                                </td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $promotionalProduct['product']->code }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $promotionalProduct['product']->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $promotionalProduct['product_variant']->color->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $promotionalProduct['product_variant']->size->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $promotionalProduct['product']->price->pair }} UAH</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6 flex-1">
                            <div class="mb-4">
                                <label for="promotionalRate" class="block mb-2 font-bold">Знижка %:</label>
                                <input type="number" min="0" max="80" class="w-full border rounded px-3 py-2" name="promotionalRate" id="promotionalRate" value="{{ $promotionalProduct['promotional_rate'] }}">
                            </div>
                            <div class="mb-4">
                                <label for="promotionalPrice" class="block mb-2 font-bold">Ціна зі знижкою %:</label>
                                <input type="text" class="w-full border rounded px-3 py-2" name="promotionalPrice" id="promotionalPrice" value="{{ $promotionalProduct['promotional_price'] }}" disabled>
                            </div>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full">
                            Відредагувати знижку
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function calculatePromotionalPrice(originalPrice, discountRate) {
        return originalPrice - (originalPrice * (discountRate / 100));
    }

    const promotionalRate = document.getElementById('promotionalRate');
    const promotionalPrice = document.getElementById('promotionalPrice');
    promotionalRate.addEventListener('change', function() {
        const discountRate = promotionalRate.value;
        const originalPrice = {{ $promotionalProduct['product']->price->pair }};
        promotionalPrice.value = calculatePromotionalPrice(originalPrice, discountRate).toFixed(2);
    });

</script>
