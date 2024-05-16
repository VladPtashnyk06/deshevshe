<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 95rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Статуси товару</h1>
                    <div class="text-center mb-4">
                        <a href="{{ route('status.create') }}" class="bg-green-600 hover:bg-green-700 block text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Створити статус товару</a>
                    </div>
                    <table class="w-full mb-5">
                        <thead>
                            <tr class="text-center border-b-2 border-gray-700">
                                <th class="p-2 text-lg">Статус товару</th>
                                <th class="p-2 text-lg">Дії</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($statuses as $status)
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $status->title }}</td>
                                <td class="px-6 py-4 text-right" style="vertical-align: top;">
                                    <a href="{{ route('status.edit', $status->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border" style="max-width: 120px">Редагувати</a>
                                    <form action="{{ route('status.destroy', $status->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 mt-3 w-full border" style="max-width: 120px">Видалити</button>
                                    </form>
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
