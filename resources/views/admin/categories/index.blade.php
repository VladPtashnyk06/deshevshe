<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 95rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Категорії</h1>
                    <div class="text-center mb-4">
                        <a href="{{ route('category.create') }}" class="bg-green-600 hover:bg-green-700 block text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Створити категорію</a>
                    </div>
                    <div class="text-center mb-4">
                        <form action="{{ route('category.index') }}" method="GET" style="display: flex; align-items: center; justify-content: center;">
                            <div class="mb-4" style="flex: 1;">
                                <label for="parent_category" class="block mb-2 font-bold">Категорія:</label>
                                <select name="parent_category" id="parent_category" class="w-full border rounded px-3">
                                    <option value="">Всі категорії</option>
                                    @foreach ($uniqueParentIds as $parentId)
                                        @if($parentId == null)
                                            <option value="{{ 'null' }}" @if(request()->input('parent_category') == 'null') selected @endif>Немає</option>
                                        @else
                                            <option value="{{ $parentId }}" @if(request()->input('parent_category') == $parentId) selected @endif>{{ $parentId }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4 ml-4 mr-2" style="flex: 1;">
                                <label for="level" class="block mb-2 font-bold">Рівні:</label>
                                <select name="level" id="level" class="w-full border rounded px-3 py-2">
                                    <option value="">Всі рівні категорій</option>
                                    @foreach ($uniqueLevels as $level)
                                        <option value="{{ $level }}" @if(request()->input('level') == $level) selected @endif>{{ $level }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">Відфільтрувати</button>
                                <button type="button" onclick="window.location='{{ route('category.index') }}'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border ml-2">Очистити фільтр</button>
                            </div>
                        </form>
                    </div>
                    <table class="w-full mb-5">
                        <thead>
                            <tr class="text-center border-b-2 border-gray-700">
                                <th class="p-2 text-lg">Категорія</th>
                                <th class="p-2 text-lg">Батьківська категорія</th>
                                <th class="p-2 text-lg">Рівень</th>
                                <th class="p-2 text-lg">Дії</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($categories as $category)
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $category->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $category->parent ? $category->parent->title : 'Немає' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $category->level }}</td>
                                <td class="px-6 py-4 text-right" style="vertical-align: top;">
                                    <a href="{{ route('category.edit', $category->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border" style="max-width: 120px">Редагувати</a>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 mt-3 w-full border" style="max-width: 120px">Видалити</button>
                                    </form>
                                    <a href="{{ route('category.createSubCategory', $category->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border" style="max-width: 120px">Створити під-категорію</a>
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
