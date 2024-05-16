<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 114rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Блоги</h1>
                    <div class="text-center mb-4">
                        <a href="{{ route('blog.create') }}" class="bg-green-600 hover:bg-green-700 block text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Створити блог</a>
                    </div>
                    <div class="text-center mb-4">
                        <form action="{{ route('blog.index') }}" method="GET" style="display: flex; align-items: center; justify-content: center;">
                            <div class="mb-4" style="flex: 1;">
                                <label for="title" class="block mb-2 font-bold">Назва блогу:</label>
                                <input type="text" name="title" id="title" value="{{ !empty(request()->input('title')) ? request()->input('title') : '' }}">
                            </div>
                            <div class="ml-2 mb-4">
                                <div class="mt-4">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">Застосувати фільтри</button>
                                    <button type="button" onclick="window.location='{{ route('blog.index') }}'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border ml-2">Очистити фільтри</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table class="w-full mb-5">
                        <thead>
                            <tr class="text-center border-b-2 border-gray-700">
                                <th class="p-2 text-lg">Зображення</th>
                                <th class="p-2 text-lg">Назва блогу</th>
                                <th class="p-2 text-lg">Опис</th>
                                <th class="p-2 text-lg">Кількість переглядів блогу</th>
                                <th class="p-2 text-lg">Кількість коментарів до блогу</th>
                                <th class="p-2 text-lg">Дії</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($blogs as $blog)
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                    @if($blog->getMedia('blog'.$blog->id)->count() > 0)
                                        @foreach($blog->getMedia('blog'.$blog->id) as $media)
                                                <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-16 w-auto rounded-md object-cover">
                                        @endforeach
                                    @else
                                        Немає
                                    @endif
                                </td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $blog->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $blog->description }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $blog->count_views }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ count($blog->comments) }}</td>
                                <td class="px-6 py-4 text-right" style="vertical-align: top;">
                                    <a href="{{ route('blog.edit', $blog->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border" style="max-width: 120px">Редагувати</a>
                                    <form action="{{ route('blog.destroy', $blog->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 mt-3 w-full border" style="max-width: 120px">Видалити</button>
                                        <a href="{{ route('blog.showComments', $blog->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border" style="max-width: 120px">Дивитися коментарі</a>
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
