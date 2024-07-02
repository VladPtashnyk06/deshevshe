<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 95rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Api</h1>
                    <div class="text-center mb-4">
                        <a href="{{ route('api.edit') }}" class="bg-green-600 hover:bg-green-700 block text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Змінити api</a>
                    </div>
                    <table class="w-full mb-5">
                        <thead>
                            <tr class="text-center border-b-2 border-gray-700">
                                <th class="p-2 text-lg">Доставка</th>
                                <th class="p-2 text-lg">Api</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">Нова Пошта</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $novaPoshtaApiKey }}</td>
                            </tr>
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">Укр Пошта</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $ukrPoshtaApiKey }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
