<tr class="text-center odd:bg-gray-200">
    <td class="px-6 py-4 font-bold" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
        {{ $category->id }}
    </td>
    <td class="px-6 py-4 font-bold" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
        {{ $prefix }} {{ $category->title }}
    </td>
    <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
        {{ $category->level }}
    </td>
    <td class="px-6 py-4 text-right">
        <a href="{{ route('category.edit', $category->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border" style="max-width: 120px; max-height: 3rem;">Редагувати</a>
        <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 mt-3 w-full border" style="max-width: 120px; max-height: 3rem; margin-top: 0">Видалити</button>
        </form>
        <br>
        <a href="{{ route('category.createSubCategory', $category->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border" style="max-width: 120px; max-height: 3rem;">Створити під-категорію</a>
    </td>
</tr>
@if ($category->children->isNotEmpty())
    @foreach ($category->children as $child)
        @include('admin.categories.category-row', ['category' => $child, 'prefix' => $prefix . $category->title . ' > '])
    @endforeach
@endif
