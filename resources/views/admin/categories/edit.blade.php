<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4 text-center">Редагувати категорію</h2>
                <form action="{{ route('category.update', $category->id) }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="parent_id" class="block mb-2 font-bold">Батьківська категорія</label>
                        <select name="parent_id" id="parent_id" class="w-full border rounded px-3 py-2">
                            <option value="">Без батьківської категорії</option>
                            @foreach($categories as $cat)
                                @include('admin.categories.options-category-edit', ['cat' => $cat, 'category' => $category, 'prefix' => ''])
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('title')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле обов'язкове і унікальне") }}</span>
                        @enderror
                        <label for="title" class="block mb-2 font-bold">Категорія</label>
                        <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2" value="{{ $category->title }}">
                    </div>

                    <div class="mb-4">
                        @error('level')
                        <span class="text-red-500">{{ htmlspecialchars($message) }}</span>
                        @enderror
                        <label for="level" class="block mb-2 font-bold">Порядок сортування</label>
                        <input type="text" name="level" id="level" class="w-full border rounded px-3 py-2" value="{{ $category->level }}">
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Оновити категорію</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
