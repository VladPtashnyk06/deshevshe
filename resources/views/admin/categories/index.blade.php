<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 95rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Категорії</h1>
                    <div class="text-center mb-4">
                        <a href="{{ route('category.create') }}" class="bg-green-600 hover:bg-green-700 block text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Створити категорію</a>
                    </div>
                    <form action="{{ route('category.index') }}" method="GET" style="display: flex; align-items: center; justify-content: center;">
                        <div class="mb-4" style="flex: 1;">
                            <label for="id" class="block mb-2 font-bold">ID категорії:</label>
                            <input type="number" name="id" id="id" value="{{ request()->input('id') }}">
                        </div>
                        <div class="mb-4" style="flex: 1;">
                            <label for="title" class="block mb-2 font-bold">Назва категорії:</label>
                            <input type="text" name="title" id="title" value="{{ request()->input('title') }}">
                        </div>
                        <div class="mb-4" style="flex: 1;">
                            <label for="level" class="block mb-2 font-bold">Рівень категорії:</label>
                            <input type="number" name="level" id="level" value="{{ request()->input('level') }}">
                        </div>
                        <div class="ml-2 mb-4">
                            <div class="mt-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">Застосувати фільтри</button>
                                <button type="button" onclick="window.location='{{ route('category.index') }}'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border ml-2">Очистити фільтри</button>
                            </div>
                        </div>
                    </form>
                    <table class="w-full mb-5">
                        <thead>
                        <tr class="text-center border-b-2 border-gray-700">
                            <th class="p-2 text-lg">ID</th>
                            <th class="p-2 text-lg">Категорія</th>
                            <th class="p-2 text-lg">Порядок сортування</th>
                            <th class="p-2 text-lg">Дії</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($filter)
                            @foreach($filterCategories as $filterCategory)
                                <tr class="text-center odd:bg-gray-200">
                                    <td class="px-6 py-4 font-bold" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                        {{ $filterCategory->id }}
                                    </td>
                                    <td class="px-6 py-4 font-bold" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                        {{ $filterCategory->title }}
                                    </td>
                                    <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                        {{ $filterCategory->level }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('category.edit', $filterCategory->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border" style="max-width: 120px; max-height: 3rem;">Редагувати</a>
                                        <form action="{{ route('category.destroy', $filterCategory->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 mt-3 w-full border" style="max-width: 120px; max-height: 3rem; margin-top: 0">Видалити</button>
                                        </form>
                                        <br>
                                        <a href="{{ route('category.createSubCategory', $filterCategory->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border" style="max-width: 120px; max-height: 3rem;">Створити під-категорію</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @foreach($categories as $category)
                                @include('admin.categories.category-row', ['category' => $category, 'prefix' => ''])
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
