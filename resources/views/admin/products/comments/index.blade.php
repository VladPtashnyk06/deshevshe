<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Коментарі до продукту</h2>

                <div class="text-center mb-4">
                    <a href="{{ route('product.index') }}" class="bg-gray-600 hover:bg-gray-700 block text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Назад</a>
                </div>

                <table class="w-full mb-5">
                    <thead>
                        <tr class="text-center border-b-2 border-gray-700">
                            <th class="p-2 text-lg">Ім'я користувача</th>
                            <th class="p-2 text-lg">Електрона адерса користувача</th>
                            <th class="p-2 text-lg">Коментар</th>
                            <th class="p-2 text-lg">Під-коментар</th>
                            <th class="p-2 text-lg">Який по рахунку</th>
                            <th class="p-2 text-lg">Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($comments as $comment)
                        <tr class="text-center odd:bg-gray-200">
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $comment->name }}</td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $comment->email }}</td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $comment->comment }}</td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $comment->parentComment ? $comment->parentComment->comment : 'Немає'   }}</td>
                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $comment->level }}</td>
                            <td class="px-6 py-4 text-right" style="vertical-align: top;">
                                <a href="{{ route('product.comments.create', $comment->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border" style="max-width: 120px">Надати відповідь</a>
                                <form action="{{ route('product.comment.delete', $comment->id) }}" method="POST">
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
</x-app-layout>
